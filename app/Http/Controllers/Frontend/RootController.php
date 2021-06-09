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
    	//get menus
    	$homeCategories = Category::where("type", "Main")->inRandomOrder()->take(8)->get();

    	//get home contents
    	$homeContentsConfig = HomeContent::get();
    	$homeContentRow1 = NULL;
    	$homeContentRow2 = NULL;
    	$homeContentRow3 = NULL;

    	if (!$homeContentsConfig->isEmpty()) {
    		foreach ($homeContentsConfig as $key => $row) {
    			//get row 1 contents
    			if ($row->position_no == 1) {
    				$homeContentRow1 = $this->getRawContent($row);
    			}

    			if ($row->position_no == 2) {
    				$homeContentRow2 = $this->getRawContent($row);
    			}

    			if ($row->position_no == 3) {
    				$homeContentRow3 = $this->getRawContent($row);
    			}
    		}
    	}

    	return view("frontendViews.index", compact('homeCategories', 'homeContentRow1', 'homeContentRow2', 'homeContentRow3'));
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
