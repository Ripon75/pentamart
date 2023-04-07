<?php

namespace App\Models;

use App\Classes\Model;
use App\Rules\NotNumeric;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $_className = 'Company';
    protected $table      = 'companies';

    // All view templates
    protected $_views = [
        'index'  => 'adminend.pages.company.index',
        'create' => 'adminend.pages.company.create',
        'edit'   => 'adminend.pages.company.edit',
        'show'   => 'adminend.pages.company.show'
    ];

    // All routes
    protected $_routeNames = [
        'index'  => 'admin.companies.index',
        'create' => 'admin.companies.create',
        'edit'   => 'admin.companies.edit',
        'show'   => 'admin.companies.show'
    ];

    protected $_columns = [
        'id' => [
            'cast'     => 'integer'
        ],
        'slug' => [
            'cast'     => 'string',
            'fillable' => true
        ],
        'name' => [
            'cast'     => 'string',
            'fillable' => true
        ],
        'parent_id' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'logo_path' => [
            'cast'     => 'string',
            'fillable' => true
        ],
        'created_at' => [
            'cast'     => 'datetime:Y-m-d H:i:s',
            'fillable' => true
        ],
        'updated_at' => [
            'cast'     => 'datetime:Y-m-d H:i:s',
            'fillable' => true
        ],
        'deleted_at' => [
            'cast'     => 'datetime:Y-m-d H:i:s'
        ]
    ];

    // Start relationship
    public function parent()
    {
        return $this->belongsTo(Self::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_comapny', 'company_id', 'category_id')->withTimestamps();
    }

    // End relationship

     // Store or update
     public function _storeOrUpdate($request, $id = 0, $action = 'store')
     {
         // TODO: Creating Form Requests
         $obj = null;
         $rules = [];


         if ($action === 'store') {
             $rules = [
                 'name' => ['required', "unique:{$this->table}", new NotNumeric]
             ];
             $request->validate($rules);
             $obj = new Self();

         } else {
             $rules = [
                 'name' => ['required', "unique:{$this->table},name,$id", new NotNumeric]
             ];
             $request->validate($rules);
             $obj = Self::find($id);

             if (!$obj) { // If the product not found
                 $msg = $this->_getMessage('not_found');
                 return $this->_makeResponse(false, null, $msg);
             }
         }

         // Get input value from request
         $name        = $request->input('name');
         $parentId    = $request->input('parent_id', null);
         $logoPath    = $request->input('logo_path', 'logo_path', null);

         $obj->name        = $name;
         $obj->slug        = $name;
         $obj->parent_id   = $parentId;
         $obj->logo_path   = $logoPath;
         $res              = $obj->save();

         if ($res) {
             $action = $action === 'store' ? $action : 'update';
             $msg = $this->_getMessage($action);
             return $this->_makeResponse(true, $obj, $msg);
         } else {
             $action = $action === 'store' ? 'failed_store' : 'failed_update';
             $msg = $this->_getMessage($action);
             return $this->_makeResponse(true, $obj, $msg);
         }
     }
}
