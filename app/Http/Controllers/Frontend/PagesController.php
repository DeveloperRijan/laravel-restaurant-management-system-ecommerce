<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\DeliveryCharge;

class PagesController extends Controller
{
    //Get item details
    public function item_details($productSlug){
        $product = Product::where(['slug'=>$productSlug, "status"=>"Active"])->first();
        if (!$product) {
            return abort(404);
        }
        $deliverCharge = DeliveryCharge::first();
    	return view("frontendViews.items.details", compact('product', 'deliverCharge'));
    }

    //get list of items for customers
    public function item_list(Request $request){
    	$menuSlug = NULL;
    	
        $query = Product::query();
        $query->where("type", "Main");
        $query->where("status", "Active");
        

        if ($request->menu != '') {
            //check category url is valid
            $category = Category::where(['url'=>$request->menu, "type"=>"Main"])->first();
            if ($category) {
                $menuSlug = $category->url;
                $query->where('category_id', $category->id);
            }else{
                \Session::flash('error', "The menu you are looking (".$request->menu.") was not found, instead all items are displaying.");
            }
            
        }

        //search query string by on submit top form
        if ($request->search != '') {
            $query->where('title', 'LIKE', "%".$request->search."%");
        }
        
        $products = $query->orderBy("created_at", "DESC")->paginate(\Config::get('constants.PRODUCT.ITEMS_PAGINATE'));
        
    	$categories = Category::where("type", "Main")->orderBy('name', "ASC")->get();

        return view("frontendViews.items.index", compact('menuSlug', 'products', 'categories'));
    }


    //filter items for customers
    public function filter_items(Request $request){

        $query = Product::query();
        $query->where("type", "Main");
        $query->where("status", "Active");


        //topFormSearchQuery by ajax
        if ($request->topFormSearchQuery != '') {
            $query->where('title', 'LIKE', "%".$request->topFormSearchQuery."%");
        }

        //search query string by ajax
        if ($request->q != '') {
            $query->where('title', 'LIKE', "%".$request->q."%");
        }

        if (is_numeric($request->category)) {
            $query->where('category_id', $request->category);
        }

        if (is_numeric($request->min_price)) {
            $query->where('price', ">=", $request->min_price);
        }
        if (is_numeric($request->max_price)) {
            $query->where('price', "<=", $request->max_price);
        }

        if ($request->sort_by_popular === "Yes") {
            $products = $query->orderBy("total_feedback", "DESC")->paginate(\Config::get('constants.PRODUCT.ITEMS_PAGINATE'));
            return view("frontendViews.items.partials.items_list", compact('products'))->render();            
        }

        $products = $query->orderBy("created_at", "DESC")->paginate(\Config::get('constants.PRODUCT.ITEMS_PAGINATE'));
        return view("frontendViews.items.partials.items_list", compact('products'))->render();
    }





    //staff items list
    public function staff_item_list(Request $request){
        $menuSlug = NULL;
        
        $query = Product::query();
        $query->where("type", "Staff");
        $query->where("status", "Active");
        

        if ($request->menu != '') {
            //check category url is valid
            $category = Category::where(['url'=>$request->menu, "type"=>"Staff"])->first();
            if ($category) {
                $menuSlug = $category->url;
                $query->where('category_id', $category->id);
            }else{
                \Session::flash('error', "The menu you are looking (".$request->menu.") was not found, instead all items are displaying.");
            }
            
        }

        //search query string by on submit top form
        if ($request->search != '') {
            $query->where('title', 'LIKE', "%".$request->search."%");
        }
        
        $products = $query->orderBy("created_at", "DESC")->paginate(\Config::get('constants.PRODUCT.ITEMS_PAGINATE'));
        
        $categories = Category::where("type", "Staff")->orderBy('name', "ASC")->get();

        return view("frontendViews.items.staff_index", compact('menuSlug', 'products', 'categories'));
    }

    public function filter_staff_items(Request $request){
        $query = Product::query();
        $query->where("type", "Staff");
        $query->where("status", "Active");


        //topFormSearchQuery by ajax
        if ($request->topFormSearchQuery != '') {
            $query->where('title', 'LIKE', "%".$request->topFormSearchQuery."%");
        }

        //search query string by ajax
        if ($request->q != '') {
            $query->where('title', 'LIKE', "%".$request->q."%");
        }

        if (is_numeric($request->category)) {
            $query->where('category_id', $request->category);
        }

        if (is_numeric($request->min_price)) {
            $query->where('price', ">=", $request->min_price);
        }
        if (is_numeric($request->max_price)) {
            $query->where('price', "<=", $request->max_price);
        }

        if ($request->sort_by_popular === "Yes") {
            $products = $query->orderBy("total_feedback", "DESC")->paginate(\Config::get('constants.PRODUCT.ITEMS_PAGINATE'));
            return view("frontendViews.items.partials.items_list", compact('products'))->render();            
        }

        $products = $query->orderBy("created_at", "DESC")->paginate(\Config::get('constants.PRODUCT.ITEMS_PAGINATE'));
        return view("frontendViews.items.partials.staff_items_list", compact('products'))->render();
    }
}
