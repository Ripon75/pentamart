<?php

namespace App\Models;

use App\Classes\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $className = 'Country';

    protected $_columns = [
        'id' => [
            'cast'     => 'integer'
        ],
        'name' => [
            'cast'     => 'string',
            'fillable' => true
        ],
        'code' => [
            'cast'     => 'string',
            'fillable' => true
        ],
        'currency_code' => [
            'cast'     => 'string',
            'fillable' => true
        ],
        'currency_symbol' => [
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
}
