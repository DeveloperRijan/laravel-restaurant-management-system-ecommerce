<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetOption extends Model
{
    protected $fillable = [
    	'type', 'email', 'token'
    ];
}
