<?php

namespace App\Models;

use Storage;
use App\Classes\Model;
use App\Rules\NotNumeric;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentGateway extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table      = 'payment_gateways';
    protected $_className = 'Payment Gateway';

     // All view templates
     protected $_views = [
        'index'  => 'adminend.pages.paymentGateway.index',
        'create' => 'adminend.pages.paymentGateway.create',
        'edit'   => 'adminend.pages.paymentGateway.edit',
        'show'   => 'adminend.pages.paymentGateway.show'
    ];

    // All routes
    protected $_routeNames = [
        'index'  => 'admin.payments.index',
        'create' => 'admin.payments.create',
        'edit'   => 'admin.payments.edit',
        'show'   => 'admin.payments.show'
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
        'code' => [
            'cast'     => 'string',
            'fillable' => true
        ],
        'status' => [
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

    //Customise function
    public function getImgSrcValueAttribute()
    {
        return $this->attributes['img_src'];
    }

    public function getImgSrcAttribute($value)
    {
        if ($value) {
            return Storage::url($value);
        } else {
            return "";
        }
    }

    // Store or update
    public function _storeOrUpdate($request, $id = 0, $action = 'store')
    {
        // TODO: Creating Form Requests
        $obj = null;
        $rules = [];


        if ($action === 'store') {
            $rules = [
                'name' => ['required', "unique:{$this->table}", new NotNumeric],
                'code' => ['nullable', "unique:{$this->table}"]
            ];
            $request->validate($rules);
            $obj = new Self();

        } else {
            $rules = [
                'name' => ['required', "unique:{$this->table},name,$id", new NotNumeric],
                'code' => ['nullable', "unique:{$this->table},code,$id"]
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
        $code        = $request->input('code', null);
        $icon        = $request->input('icon', null);
        $status      = $request->input('status', 'activated');
        $description = $request->input('description', null);

        $obj->name        = $name;
        $obj->slug        = $name;
        $obj->code        = $code;
        $obj->icon        = $icon;
        $obj->status      = $status;
        $obj->description = $description;
        $res              = $obj->save();

        if ($res) {
            $action = $action === 'store' ? $action : 'update';
            if($request->hasFile('file')) {
                $oldImagePath = $obj->img_src_value;
                if ($oldImagePath) {
                    Storage::delete($oldImagePath);
                }

                $file       = $request->file('file');
                $uploadPath = $obj->_getImageUploadPath();
                $path       = Storage::put($uploadPath, $file);
                $obj->img_src = $path;
                $obj->save();
            }
            $msg = $this->_getMessage($action);
            return $this->_makeResponse(true, $obj, $msg);
        } else {
            $action = $action === 'store' ? 'failed_store' : 'failed_update';
            $msg = $this->_getMessage($action);
            return $this->_makeResponse(true, $obj, $msg);
        }
    }
}
