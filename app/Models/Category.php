<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
    	"type",
        "parent_id",
    	"name",
    	"url",
    	"featured_img",
    	"is_sub_child",
    	"created_by",
    	"creator_id"
    ];

    public function get_products(){
        return $this->hasMany("App\Models\Product", "category_id", "id")->where("status", "Active")->orderBy("created_at", "DESC");
    }
}
