<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
    	"order_by",
        "user_id",
    	"order_data",
    	"address_data",
    	"payment_type",
    	"payment_method",
    	"payment_id",
    	"status"
    ];

    public function get_customer(){
        return $this->belongsTo("App\Models\User", 'user_id')->withTrashed();
    }

    public function get_payment(){
        return $this->belongsTo("App\Models\Payment", 'payment_id');//payment tbl data will not delete never...
    }
}
