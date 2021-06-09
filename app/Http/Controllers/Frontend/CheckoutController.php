<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Http\Controllers\CheckoutSummary;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CustomerAddress;
use Auth;

class CheckoutController extends Controller
{
    //checkout page
    public function checkout(Request $request){
    	if (!Auth::check()) {
    		return view("frontendViews.checkout.checkout");
    	}
        //check is customer or else
        if (Auth::user()->type !== "Customer") {
            return redirect()->route('root_page')->with('sw_alert_session_error', "Only Customers have access permission to the checkout page - Thanks");
        }

        //if auth then
        $obj = new CheckoutSummary();

        if (is_numeric($request->removeItem)) {
            $cartItem = Cart::where(['id'=>$request->removeItem, 'user_id'=>Auth::user()->id])->delete();
            $data = $obj->getCheckoutSummary();
            return view("frontendViews.checkout.partials.checkout_data", compact('data'))->render();
        }

        //if has request for getting address details by id then
        if ($request->has("get_address_details_by_id") && $request->get_address_details_by_id != '') {
            $addressDetails = CustomerAddress::where(['id'=>decrypt($request->get_address_details_by_id), 'user_id'=>Auth::user()->id])->first();
            return view("frontendViews.checkout.partials.address_preview", compact('addressDetails'))->render();
        }

    	

        //if request ajax has coupon code for apply then
    	if ($request->has("coupon_code") && $request->coupon_code != '') {
    		$data = $obj->getCheckoutSummary($request->coupon_code);
    		return view("frontendViews.checkout.partials.checkout_data", compact('data'))->render();
    	}


        //checkout steps - address
    	if ($request->has("step") && $request->step == 'address') {
            if (!Cart::where('user_id', Auth::user()->id)->exists()) {
                return redirect("checkout")->with("error", "SORRY- Your cart is empty!");
            }
    		$addresses = CustomerAddress::where('user_id', Auth::user()->id)->orderBy("created_at", "DESC")->get();
    		return view("frontendViews.checkout.checkout", compact('addresses'));
    	}

        //checkout steps - payment
        if ($request->has("step") && $request->step == 'payment') {
            
            if (!Cart::where('user_id', Auth::user()->id)->exists()) {
                return redirect("checkout")->with("error", "SORRY- Your cart is empty!");
            }

            if ($request->address == '') {
                return redirect("checkout?step=address")->with("error", "Please select address");
            }

            $checkAddressUsingAddressID = CustomerAddress::where(['id'=>decrypt($request->address), 'user_id'=>Auth::user()->id])->first();
            if (!$checkAddressUsingAddressID) {
                return redirect("checkout?step=address")->with("error", "Invalid address selected | Address not found");
            }

            //get data
            $data = NULL;

            if (isset($couponApplied['is_applied']) && $couponApplied['is_applied'] === true) {
                $data = $obj->getCheckoutSummary($couponApplied['requested_coupon_code']);

            }else{
                $data = $obj->getCheckoutSummary();
            }

            if ($data === NULL) {
                return redirect("checkout")->with("error", "SORRY- No orderable items found in your cart!!");
            }
            
            if (\Session::has("checkOutWholeDataToOrder")) {
                \Session::forget("checkOutWholeDataToOrder");
            }

            \Session::put("checkOutWholeDataToOrder", $data);
            return view("frontendViews.checkout.checkout", compact('data'));
        }


    	$data = $obj->getCheckoutSummary();
    	return view("frontendViews.checkout.checkout", compact('data'));
    	
    	
    }



}
