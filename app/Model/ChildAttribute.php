<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildAttribute extends Model
{
    use SoftDeletes;
    protected $fillable = ['attribute_id', 'value', 'value_arabic', 'created_by', 'updated_by'];

    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getParentAttribute()
    {
        return $this->belongsTo('App\Model\Attributes', 'attribute_id', 'id');
    }
}
