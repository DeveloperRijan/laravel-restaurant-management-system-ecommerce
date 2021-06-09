<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
    	"coupon_code",
    	"coupon_discount",
    	"expire_date",
    	"number_of_coupon",
    	"coupon_used",
    	"status"
    ];
}
