<?php

namespace App\Models;

use App\Classes\Model;
use App\Rules\NotNumeric;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Generic extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table      = 'generics';
    protected $_className = 'Generic';

     // All view templates
     protected $_views = [
        'index'  => 'adminend.pages.generic.index',
        'create' => 'adminend.pages.generic.create',
        'edit'   => 'adminend.pages.generic.edit',
        'show'   => 'adminend.pages.generic.show'
    ];

    // All routes
    protected $_routeNames = [
        'index'  => 'admin.generics.index',
        'create' => 'admin.generics.create',
        'edit'   => 'admin.generics.edit',
        'show'   => 'admin.generics.show'
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
        'strength' => [
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

    // Relationship
    public function products()
    {
        return $this->hasMany(Product::class);
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
        $name     = $request->input('name');
        $strength = $request->input('strength', null);

        $obj->name     = $name;
        $obj->slug     = $name;
        $obj->strength = $strength;
        $res           = $obj->save();

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
