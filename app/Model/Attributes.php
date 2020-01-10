<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attributes extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['attribute', 'attribute_arabic', 'value', 'value_arabic', 'created_by', 'updated_by'];
    
    protected $dates = ['deleted_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childAttribute()
    {
        return $this->hasMany('App\Model\ChildAttribute', 'attribute_id', 'id');
    }

    
    // This is the Accessor for manipulate data when initialize the model
    // public function getTaxNameAttribute($value)
    // {
    //     return strtoupper($value);
    // }
    
}
