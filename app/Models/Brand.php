<?php

namespace App\Models;

use App\Classes\Model;
use App\Rules\NotNumeric;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table      = 'brands';
    protected $_className = 'Brand';

    // All view templates
    protected $_views = [
        'index'  => 'adminend.pages.brand.index',
        'create' => 'adminend.pages.brand.create',
        'edit'   => 'adminend.pages.brand.edit',
        'show'   => 'adminend.pages.brand.show'
    ];

    // All routes
    protected $_routeNames = [
        'index'  => 'admin.brands.index',
        'create' => 'admin.brands.create',
        'edit'   => 'admin.brands.edit',
        'show'   => 'admin.brands.show'
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
        'status' => [
            'cast'     => 'string',
            'fillable' => true
        ],
        'logo_path' => [
            'cast'     => 'string',
            'fillable' => true
        ],
        'type_id' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'company_id' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'shop_id' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'description' => [
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

    // Relation start =========================
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    // Relation end ============================

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
        $companyId   = $request->input('company_id', null);
        $status      = $request->input('status', 'draft');
        $logoPath    = $request->input('logo_path', 'logo_path', null);
        $description = $request->input('description', null);

        $obj->name        = $name;
        $obj->slug        = $name;
        $obj->status      = $status;
        $obj->company_id  = $companyId;
        $obj->logo_path   = $logoPath;
        $obj->description = $description;
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
