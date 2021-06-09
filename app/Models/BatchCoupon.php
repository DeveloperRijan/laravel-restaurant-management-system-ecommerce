<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchCoupon extends Model
{
    use HasFactory;
    protected $fillable = [
    	"type",
    	"city",
    	"designation_id",
    	"batch_10",
    	"batch_20",
    	"coupon_percent"
    ];
}
