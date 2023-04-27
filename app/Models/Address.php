<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'contact_name',
        'phone_number',
        'line_1',
        'line_2',
        'postal_code',
        'area_id'
    ];

    protected $casts = [
        'id'           => 'integer',
        'title'        => 'string',
        'user_id'      => 'integer',
        'contact_name' => 'string',
        'phone_number' => 'string',
        'line_1'       => 'string',
        'line_2'       => 'string',
        'postal_code'  => 'string',
        'area_id'      => 'integer',
        'created_at'   => 'datetime:Y-m-d H:i:s',
        'updated_at'   => 'datetime:Y-m-d H:i:s',
        'deleted_at'   => 'datetime:Y-m-d H:i:s'
    ];

    // Relation start =======================================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    // Relation end ==========================================
}
