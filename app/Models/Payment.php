<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        "paid_for",
    	"user_id",
    	"payment_method",
    	"paid_amount",
    	"payer_name",
    	"payer_email",
    	"paypal_transaction_id",
    	"payer_country",
    	"status"
    ];
}
