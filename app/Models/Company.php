<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
    	"name",
    	"code",
    	"address_line_one",
    	"address_line_two",
    	"city",
    	"state",
    	"start_time",
    	"end_time",
    	"start_day",
    	"end_day",
    	"can_order_any_time",
    	"discount_percent",
    	"status"
    ];
}
