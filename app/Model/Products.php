<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;

    protected $fillable = ['product_name', 'product_name_arabic', 'product_code', 'product_description', 'product_description_arabic', 'category_id', 'tax_id', 'price', 'sale_price', 'product_image', 'product_image_arabic', 'product_other_image', 'product_other_image_arabic', 'product_attribute', 'effective_from', 'effective_to', 'status', 'created_by', 'updated_by', 'is_latest', 'is_futured'];

    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getTax()
    {
        return $this->belongsTo('App\Model\Tax', 'tax_id', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getChildProduct()
    {
        return $this->hasMany('App\Model\ChildProducts', 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getProductSpecification()
    {
        return $this->hasMany('App\Model\ProductSpecification', 'product_id', 'id');
    }

    // This is the Accessor for manipulate data when initialize the model
    // public function getProductAttributeAttribute($value)
    // {
    //     return unserialize($value);
    // }
}
