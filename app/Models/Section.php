<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory, Userstamps;

    protected $fillable = [
        'title',
        'link',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'id'         => 'integer',
        'title'      => 'string',
        'link'       => 'string',
        'status'     => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'section_item', 'section_id', 'item_id')->withTimestamps();
    }
}
