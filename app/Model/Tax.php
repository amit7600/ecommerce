<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax extends Model
{
    use SoftDeletes;

    protected $table = "taxes";

    protected $fillable = ['tax_name', 'tax_name_arabic', 'tax_rate', 'tax_description', 'tax_description_arabic', 'is_active', 'created_by', 'updated_by'];
    
    protected $dates = ['deleted_at'];
    
    // This is the Accessor for manipulate data when initialize the model
    // public function getTaxNameAttribute($value)
    // {
    //     return strtoupper($value);
    // }
}
