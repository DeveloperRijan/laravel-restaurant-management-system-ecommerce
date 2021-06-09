<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAddress extends Model
{
    use HasFactory;
    protected $fillable = [
    	"user_id",
    	"nick_name",
    	"mobile_number",
    	"address_line_1",
    	"address_line_2",
    	"city",
    	"post_code",
    	"note"
    ];
}
