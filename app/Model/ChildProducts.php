<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildProducts extends Model
{
    use SoftDeletes;

    protected $fillable = ['product_id', 'child_attribute_ids', 'price', 'sale_price', 'product_image', 'product_image_arabic', 'product_other_image', 'product_other_image_arabic', 'created_by', 'updated_by'];

    protected $dates = ['deleted_at'];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getProduct()
    {
        return $this->belongsTo('App\Model\Products', 'product_id', 'id');
    }
}
