<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    Protected $fillable = [
    	'email','token'
    ];
}
