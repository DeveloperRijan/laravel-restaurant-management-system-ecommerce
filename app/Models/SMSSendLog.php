<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMSSendLog extends Model
{
    use HasFactory;
    protected $fillable = [
    	"type",
    	"user_id",
    	"response"
    ];
}
