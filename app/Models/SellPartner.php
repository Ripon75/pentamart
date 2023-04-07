<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellPartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'contact_name',
        'contact_number'
    ];

    protected $casts = [
        'name'           => 'string',
        'slug'           => 'string',
        'contact_name'   => 'string',
        'contact_number' => 'string',
        'created_at'     => 'datetime: Y-m-d H:i:s',
        'updated_at'     => 'datetime: Y-m-d H:i:s'
    ];
}
