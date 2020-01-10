<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    protected $fillable = [
        'name','email_subject','email_body','status', 'created_by', 'updated_by'
    ];

    use SoftDeletes;
}
