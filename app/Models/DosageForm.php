<?php

namespace App\Models;

use App\Classes\Model;
use App\Rules\NotNumeric;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DosageForm extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table      = 'dosage_forms';
    protected $_className = 'Dosage Form';

     // All view templates
     protected $_views = [
        'index'  => 'adminend.pages.dosageForm.index',
        'create' => 'adminend.pages.dosageForm.create',
        'edit'   => 'adminend.pages.dosageForm.edit',
        'show'   => 'adminend.pages.dosageForm.show'
    ];

    // All routes
    protected $_routeNames = [
        'index'  => 'admin.dosage-forms.index',
        'create' => 'admin.dosage-forms.create',
        'edit'   => 'admin.dosage-forms.edit',
        'show'   => 'admin.dosage-forms.show'
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
        'parent_id' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'description' => [
            'cast'     => 'integer',
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

    // Relationship
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

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
        $parentID    = $request->input('parent_id', null);
        $status      = $request->input('status', 'draft');
        $description = $request->input('description', null);

        $obj->name        = $name;
        $obj->slug        = $name;
        $obj->status      = $status;
        $obj->parent_id   = $parentID;
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
