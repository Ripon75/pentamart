<?php

namespace App\Models;

use App\Classes\Model;
use App\Rules\NotNumeric;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $_className = 'Category';

    protected $table = 'categories';

    protected $_defaultWith = ['family', 'attributes', 'companies'];

     // All view templates
     protected $_views = [
        'index'  => 'adminend.pages.category.index',
        'create' => 'adminend.pages.category.create',
        'edit'   => 'adminend.pages.category.edit',
        'show'   => 'adminend.pages.category.show'
    ];

    // All routes
    protected $_routeNames = [
        'index'  => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'edit'   => 'admin.categories.edit',
        'show'   => 'admin.categories.show'
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
        'color' => [
            'cast'     => 'string',
            'fillable' => true
        ],
        'parent_id' => [
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

   // start relationship
   public function parent()
   {
       return $this->belongsTo(Self::class);
   }

   public function products()
   {
       return $this->belongsToMany(Product::class, 'product_category', 'category_id', 'product_id')->withTimestamps();
   }

   public function attributeFamilies()
   {
        return $this->belongsToMany(ProductAttributeFamily::class, 'prod_attr_fam_cat_map', 'cat_id', 'attr_fam_id')->withTimestamps();
   }

   public function family()
   {
        return $this->belongsTo(Family::class, 'family_id', 'id');
   }

   public function attributes()
   {
        return $this->belongsToMany(Attribute::class, 'category_attribute', 'category_id', 'attribute_id')->withTimestamps();
   }

   public function companies()
   {
        return $this->belongsToMany(Company::class, 'category_company', 'category_id', 'company_id')->withTimestamps();
   }
   // End relationship

    // Store or update
    public function _storeOrUpdate($request, $id = 0, $action = 'store')
    {
        // TODO: Creating Form Requests
        $obj   = null;
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
        $name         = $request->input('name');
        $status       = $request->input('status', 'draft');
        $color        = $request->input('color', null);
        $parentId     = $request->input('parent_id', null);
        $familyId     = $request->input('family_id', null);
        $attributeIds = $request->input('attribute_ids', null);
        $companyIds   = $request->input('company_ids', null);
        $parentId     = $parentId ?? null;
        $description  = $request->input('description', null);

        $obj->name         = $name;
        $obj->slug         = $name;
        $obj->status       = $status;
        $obj->parent_id    = $parentId;
        $obj->color        = $color;
        $obj->description  = $description;
        $res = $obj->save();

        if ($res) {
            $obj->attributes()->sync($attributeIds);
            $obj->companies()->sync($companyIds);

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
