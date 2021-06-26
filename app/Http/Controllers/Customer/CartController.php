<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CheckoutSummary;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Carbon\Carbon;
use Auth;

class CartController extends Controller
{
    //add to cart
    public function add(Request $request){
        if (!Auth::check()) {
            return response()->json(['msg'=>"Please login to add product to Cart!"], 422);
        }

        if (Auth::user()->type !== "Customer") {
            return response()->json(['msg'=>"Only customers are allowed to perform this action!"], 422);
        }


        $data = Product::where(['id'=>decrypt($request->productID)])->first();
        if (!$data) {
            return response()->json(['msg'=>"Product not found !"], 422);
        }

        if ($data->status !== "Active") {
            return response()->json(['msg'=>"The product you have selected is unavailable now !"], 422);
        }

        if ($data->type !== "Main") {
            return response()->json(['msg'=>"The product might be not for you !"], 422);
        }

        if ($data->stock_status !== "Available") {
            return response()->json(['msg'=>"The item you have selected is Sold Out !"], 422);
        }

        //check already added
        $exist = Cart::where([
            'user_id'=>Auth::user()->id,
            'product_id'=>$data->id
        ])->first();

        if ($exist) {
            return response()->json(['msg'=>"Already Added!"], 422);
        }

        $cart = new Cart([
            "user_id"=>Auth::user()->id,//Customer ID
            "product_id"=>$data->id,
            "created_at"=>Carbon::now()
        ]);

        if ($cart->save()) {
            return response()->json("Item added to cart", 200);
        }
        return response()->json(["msg"=>"Internal server error | please try again later."], 422);
    }


    //return total items of cart
    public function get_cart_items(Request $request){
        if (!Auth::check()) {
            return response()->json([
                "msg"=>"NotAuth",
                "data"=>0
            ], 200);
        }
        if ($request->type === "totalItems") {
            $items = Cart::where('user_id', Auth::user()->id)->count();

            return response()->json([
                "msg"=>"Auth",
                "data"=>$items
            ], 200);
        }

        //error
        return response()->json([
            "msg"=>"Invalid Access"
        ], 422);
    }




    public function update_qty(Request $request){
        //get cart
        $cartData = Cart::where('id', $request->cart_id)->first();
        if (!$cartData) {
            return response()->json('Invalid Request', 422);
        }

        //update the qty
        $newQTY_Val = NULL;
        if ($request->type === "Increase") {
          $newQTY_Val  = ($cartData->qty + 1);

        }elseif ($request->type === "Decrease") {
            $newQTY_Val  = ($cartData->qty - 1);
            if ($newQTY_Val == 0) {
               return response()->json("Quantity can not be less than 1", 422);
            }
        }



        $updated = Cart::where('id', $request->cart_id)->update([
            'qty'=>$newQTY_Val
        ]);
      
        
        //get cart deatils
        $obj = new CheckoutSummary();
        $data = $obj->getCheckoutSummary();

        return view("frontendViews.checkout.partials.checkout_data", compact('data'))->render();
    }




    //order now link
    public function order_now_btn(Request $request){
        return $request;
        if (!Auth::check()) {
            return abort(403);
        }

        $redirectTo = "checkout.init";
        $productType = "Main";
        if (Auth::user()->type === "Staff") {
            $redirectTo = "staff.order.page";
            $productType = "Staff";
        }

        if ($request->product_id == '') {
            return redirect()->route($redirectTo)->with("error", "SORRY - The product id is missing to make order... !");
        }

        //check product
        $productData = Product::where(['id'=>decrypt($request->product_id)])->first();
        if (!$productData) {
            return abort(404);
        }

        if ($productData->status !== "Active") {
            return redirect()->route($redirectTo)->with("error", "SORRY - The product you have selected is unavailable now !");
        }

        if ($productData->type !== $productType) {
            return redirect()->route($redirectTo)->with("error", "SORRY - The product might be not for you !");
        }

        if ($productData->stock_status !== "Available") {
            return redirect()->route($redirectTo)->with("error", "SORRY - The item you have selected is Sold Out !");
        }

        if (!Cart::where(['user_id'=>Auth::user()->id, "product_id"=>$productData->id])->exists()) {
            //add item to cart
            Cart::insert([
                "user_id"=>Auth::user()->id,
                "product_id"=>$productData->id,
                "qty"=>(is_numeric($request->qty) ? $request->qty : 1),
                "created_at"=>Carbon::now()
            ]);
        }

        return redirect()->route($redirectTo);
    }
}
