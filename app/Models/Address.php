<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory, Userstamps, SoftDeletes;

    protected $fillable = [
        'title',
        'address',
        'user_id',
        'phone_number',
        'district_id',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'title'        => 'string',
        'address'      => 'string',
        'user_id'      => 'integer',
        'phone_number' => 'string',
        'district_id'  => 'integer',
        'created_by'   => 'integer',
        'updated_by'   => 'integer',
        'created_at'   => 'datetime:Y-m-d H:i:s',
        'updated_at'   => 'datetime:Y-m-d H:i:s',
        'deleted_at'   => 'datetime:Y-m-d H:i:s'
    ];

    // Relation start =======================================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    // Relation end ==========================================
}
