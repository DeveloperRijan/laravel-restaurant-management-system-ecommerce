<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'name',
        'email',
        'phone',
        'code',
        'company_name',
        'address_line_one',
        'address_line_two',
        'city',
        'state',
        'post_code',
        'start_time',
        'end_time',
        'start_day',
        'end_day',
        'can_order_any_time',
        'password',
        'designation_id',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function get_orders(){
        return $this->hasMany("App\Models\Order", "user_id");
    }


    public function get_staff_coupon(){
        return $this->belongsTo("App\Models\StaffBatchCoupon", 'id', "user_id");
    }

    public function get_designation(){
        return $this->belongsTo("App\Models\Designation", 'designation_id', 'id');
    }
}
