<?php

namespace App\Models;

use App\Classes\Model;
use App\Rules\NotNumeric;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryGateway extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table      = 'delivery_gateways';
    protected $_className = 'Delivery Gateway';

     // All view templates
     protected $_views = [
        'index'  => 'adminend.pages.deliveryGateway.index',
        'create' => 'adminend.pages.deliveryGateway.create',
        'edit'   => 'adminend.pages.deliveryGateway.edit',
        'show'   => 'adminend.pages.deliveryGateway.show'
    ];

    // All routes
    protected $_routeNames = [
        'index'  => 'admin.deliveries.index',
        'create' => 'admin.deliveries.create',
        'edit'   => 'admin.deliveries.edit',
        'show'   => 'admin.deliveries.show'
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
        'price' => [
            'cast'     => 'decimal:2',
            'fillable' => true
        ],
        'min_delivery_time' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'max_delivery_time' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'delivery_time_unit' => [
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

    // Store or update
    public function _storeOrUpdate($request, $id = 0, $action = 'store')
    {
        // TODO: Creating Form Requests
        $obj = null;
        $rules = [];


        if ($action === 'store') {
            $rules = [
                'name'  => ['required', "unique:{$this->table}", new NotNumeric],
                'code'  => ['required', "unique:{$this->table}"],
                'price' => ['required']
            ];
            $request->validate($rules);
            $obj = new Self();

        } else {
            $rules = [
                'name' => ['required', "unique:{$this->table},name,$id", new NotNumeric],
                'code' => ['required', "unique:{$this->table},code,$id"],
                'price' => ['required']
            ];
            $request->validate($rules);
            $obj = Self::find($id);

            if (!$obj) { // If the product not found
                $msg = $this->_getMessage('not_found');
                return $this->_makeResponse(false, null, $msg);
            }
        }

        // Get input value from request
        $name             = $request->input('name');
        $code             = $request->input('code', null);
        $price            = $request->input('price', null);
        $minDeliveryTime  = $request->input('min_delivery_time', null);
        $maxDeliveryTime  = $request->input('max_delivery_time', null);
        $deliveryTimeUnit = $request->input('delivery_time_unit', null);
        $status           = $request->input('status', 'draft');
        $description      = $request->input('description', null);

        $obj->name               = $name;
        $obj->slug               = $name;
        $obj->code               = $code;
        $obj->price              = $price;
        $obj->min_delivery_time  = $minDeliveryTime;
        $obj->max_delivery_time  = $maxDeliveryTime;
        $obj->delivery_time_unit = $deliveryTimeUnit;
        $obj->status             = $status;
        $obj->description        = $description;
        $res                     = $obj->save();

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
