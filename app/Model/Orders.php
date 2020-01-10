<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'transaction_id', 'order_number', 'status', 'payment_method', 'ordered_at', 'in_progress_at', 'shipped_at', 'completed_at', 'cancel_reason', 'cancelled_by', 'cancelled_at', 'sub_total', 'discount', 'offer', 'tax_collected', 'grand_total', 'shipping_address_id', 'created_by', 'updated_by', 'ip'];

    protected $dates = ['deleted_at'];

    public function orderDetails()
    {
        return $this->hasMany('\App\Model\OrderDetails', 'order_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo('\App\Model\ShippingAddress', 'shipping_address_id', 'id');
    }
    
}
