<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\HomeContent;
use App\Models\Product;

class RootController extends Controller
{
    public function index(){
    	$categories = Category::where('type', "Main")
        ->orderBy("name", "ASC")
        ->with("get_products")
        ->get();
    	return view("frontendViews.index", compact('categories'));
    }


    private function getRawContent($row){
    	$product = Product::query();
    	$product->where('category_id', $row->category_id);

    	if ($row->order_by === "Latest") {
    		$product->orderBy('created_at', "DESC");
    	}

    	if ($row->order_by === "Oldest") {
    		$product->orderBy('created_at', "ASC");
    	}

    	if ($row->order_by === "Random") {
    		$product->inRandomOrder();
    	}
    	$product->with('get_category');
    	$product->take(\Config::get("constants.PRODUCT.HOME_PROUDUTS_LOAD"));
    	return $product->get();
    }

}
