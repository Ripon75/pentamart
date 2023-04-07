<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'input_type',
        'required',
        'visible_on_front',
        'comparable',
        'user_defined'
    ];

    protected $casts = [
        'slug'             => 'string',
        'name'             => 'string',
        'input_type'       => 'string',
        'required'         => 'boolean',
        'visible_on_front' => 'boolean',
        'comparable'       => 'boolean',
        'user_defined'     => 'boolean',
        'created_at'       => 'datetime:Y-m-d H:i:s',
        'updated_at'       => 'datetime:Y-m-d H:i:s'
    ];

    public $inputTypes = [
        [
            'label' => 'Text',
            'value' => 'text'
        ],
        [
            'label' => 'Textarea',
            'value' => 'textarea'
        ],
        [
            'label' => 'Select Single',
            'value' => 'select-single'
        ],
        [
            'label' => 'Select Multiple',
            'value' => 'select-multiple'
        ],
        [
            'label' => 'Checkbox Single',
            'value' => 'checkbox-single'
        ],
        [
            'label' => 'Checkbox Multiple',
            'value' => 'checkbox-multiple'
        ]
    ];

    public $valueCasts = [
        [
            'label' => 'String',
            'value' => 'string'
        ],
        [
            'label' => 'Textarea',
            'value' => 'textarea'
        ],
        [
            'label' => 'Integer',
            'value' => 'integer'
        ],
        [
            'label' => 'Float',
            'value' => 'float'
        ],
        [
            'label' => 'Boolean',
            'value' => 'boolean'
        ]
    ];

    public function familes()
    {
        return $this->belongsToMany(Family::class, 'family_attribute', 'attribute_id', 'family_id')
        ->withPivot('attribute_group')->withTimestamps();
    }

    public function options()
    {
        return $this->hasMany(AttributeOption::class, 'attribute_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attribute', 'attribute_id', 'product_id')
        ->withPivot('value')->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_attribute', 'attribute_id', 'category_id')->withTimestamps();
    }
}
