<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offers extends Model
{
    use SoftDeletes;

    protected $fillable = ['coupon_code', 'discount', 'discount_amount', 'minimum_order_amount', 'minimum_offer_amount', 'start_date', 'end_date', 'status', 'created_by', 'updated_by'];

    protected $dates = ['deleted_at'];
}
