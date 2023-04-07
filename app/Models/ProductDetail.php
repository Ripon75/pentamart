<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDetail extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'product_id',
        'indication',
        'description',
        'pharmacology',
        'dosage',
        'administration',
        'interaction',
        'contraindication',
        'side_effect',
        'pregnancy',
        'warning',
        'uses',
        'therapeutic',
        'storage_condition',
        'disclaimer'
    ];

    protected $casts = [
        'product_id'        => 'integer',
        'indication'        => 'string',
        'description'       => 'string',
        'pharmacology'      => 'string',
        'dosage'            => 'string',
        'administration'    => 'string',
        'interaction'       => 'string',
        'contraindication'  => 'string',
        'side_effect'       => 'string',
        'pregnancy'         => 'string',
        'warning'           => 'string',
        'uses'              => 'string',
        'therapeutic'       => 'string',
        'storage_condition' => 'string',
        'disclaimer'        => 'string',
        'created_at'        => 'datetime:Y-m-d H:i:s',
        'updated_at'        => 'datetime:Y-m-d H:i:s'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
