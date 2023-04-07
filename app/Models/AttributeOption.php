<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_id',
        'value',
        'label'
    ];

    protected $casts = [
        'attribute_id' => 'string',
        'value'        => 'string',
        'label'        => 'string',
        'created_at'   => 'datetime:Y-m-d H:i:s',
        'updated_at'   => 'datetime:Y-m-d H:i:s'
    ];

    public function attributes()
    {
        return $this->blongsTo(Attribute::class, 'attribute_id', 'id');
    }
}
