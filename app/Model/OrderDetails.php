<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetails extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['product_child_id', 'order_id', 'quantity', 'removed_by', 'remove_reason', 'sub_total', 'discount', 'offer', 'tax_collected', 'grand_total', 'created_by', 'updated_by'];

    protected $dates = ['deleted_at'];

    public function orders()
    {
       return $this->belongsTo('\App\Model\Orders', 'id', 'order_id');
    }

    public function childProducts()
    {
       return $this->belongsTo('\App\Model\ChildProducts', 'product_child_id', 'id');
    }
}
