<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
    	'type',
    	'for',
    	'notification_from',
    	'to_id',
    	'message',
    	'url',
    	'status'
    ];
}
