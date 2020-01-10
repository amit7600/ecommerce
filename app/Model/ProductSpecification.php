<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSpecification extends Model
{
    use SoftDeletes;

    protected $fillable = ['product_id', 'key', 'value', 'created_by', 'updated_by'];

    protected $dates = ['deleted_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getProduct()
    {
        return $this->belongsTo('App\Model\Products', 'product_id', 'id');
    }
}
