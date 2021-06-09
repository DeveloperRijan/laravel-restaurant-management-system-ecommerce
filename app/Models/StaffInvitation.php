<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffInvitation extends Model
{
    use HasFactory;
    protected $fillable = [
    	"staff_id",
    	"name",
    	"email",
    	"designation",
    	"status"
    ];
}
