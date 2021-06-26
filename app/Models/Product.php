<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
    	"type",
        "item_type",
        "product_id",
        "category_id",
    	"title",
        "slug",
    	"description",
    	"price",
    	"discount_price",
    	"images",
        "field_names",
        "field_values",
        "options",
        "size",
        "note",
    	"total_feedback",
    	"status",
        "stock_status"
    ];

    public function get_category(){
        return $this->belongsTo("App\Models\Category", "category_id", "id");
    }
    
    public function feedbackFormat($num){
      if($num>1000) {

            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('k', 'm', 'b', 't');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];

            return $x_display;

      }

      return $num;

    }
}
