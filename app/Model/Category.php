<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['parent_category', 'category_name', 'category_name_arabic', 'category_image', 'tax_id', 'status', 'created_by', 'updated_by'];

    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxes()
    {
        return $this->belongsTo('App\Model\Tax', 'tax_id', 'id');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getPorduct()
    {
        return $this->hasMany('App\Model\Products', 'category_id', 'id');
    }

}
