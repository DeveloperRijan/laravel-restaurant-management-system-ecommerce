<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportTicket extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
    	"user_id",
    	"ticket_id",
    	"subject",
    	"status",
    	"closed_by"
    ];

    public function get_chats(){
    	return $this->hasMany("App\Models\Chat", "ticket_id", "ticket_id");
    }

    public function get_user(){
    	return $this->belongsTo("App\Models\User", "user_id")->withTrashed();
    }
}
