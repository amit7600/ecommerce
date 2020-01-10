<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingAddress extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'first_name', 'last_name', 'mobile_number', 'pincode', 'address', 'area', 'landmark', 'city', 'state', 'address_type', 'created_by', 'updated_by'];

    protected $dates = ['deleted_at'];
}
