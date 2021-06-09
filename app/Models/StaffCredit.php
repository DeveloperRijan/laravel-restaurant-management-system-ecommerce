<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffCredit extends Model
{
    use HasFactory;
    protected $fillable = [
    	"user_id",
    	"total_balance",
    	"remaining_balance"
    ];
}
