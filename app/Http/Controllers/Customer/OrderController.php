<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CheckoutSummary;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Models\Notification;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Auth;

class OrderController extends Controller
{
    //post order
    public function post_order(Request $request){
    	if (!\Session::has("checkOutWholeDataToOrder")) {
    		return redirect()->route("checkout.init")->with("error", "SORRY - Something went wrong - no order data found");
    	}

    	if (decrypt($request->payment_type) === "cod") {
    		return $this->processOrder($request, "COD");
    	}

    	if (decrypt($request->payment_type) === "paid") {
    		return $this->processOrder($request, "PAID");
    	}

        \Session::forget("checkOutWholeDataToOrder");
    	return redirect()->route("checkout.init")->with("error", "Invalid order payment type | Please contact administration for futher help!");
    }


    private function processOrder($request, $paymentType){
    	//update coupon used status
    	$checkOutWholeDataToOrder = \Session::get("checkOutWholeDataToOrder");

    	if (isset($checkOutWholeDataToOrder['couponAppliedResponse']) && $checkOutWholeDataToOrder['couponAppliedResponse'] != null && $checkOutWholeDataToOrder['couponAppliedResponse']['is_applied'] === true) {
    		$coupon = Coupon::where('coupon_code', $checkOutWholeDataToOrder['couponAppliedResponse']['requested_coupon_code'])->first();
        	$coupon->update(['coupon_used'=>($coupon->coupon_used+1)]);
    	}
        

    	//get address
    	$shippingAddress = CustomerAddress::where('id', decrypt($request->addressID))->first();

    	//if paid then save payment details
    	$payment_method = NULL;
    	$payment_id = NULL;

    	if ($paymentType === "PAID") {
    		$payment = new Payment([
	    		"user_id"=>Auth::user()->id,
	    		"payment_method"=>"Paypal",
	    		"paid_amount"=>$request->p_paid_amount,
	    		"payer_name"=>$request->p_payer_name,
	    		"payer_email"=>$request->p_payer_email,
	    		"paypal_transaction_id"=>$request->p_transaction_id,
	    		"payer_country"=>$request->p_payer_country,
	    		"status"=>$request->p_status,
	    		"created_at"=>Carbon::now()
	    	]);
	    	if ($payment->save()) {
	    		$payment_method = "Paypal";
	    		$payment_id = $payment->id;
	    	}
    	}

    	$order = new Order();
    	$order->user_id = Auth::user()->id;
    	$order->order_data = json_encode($checkOutWholeDataToOrder);
    	$order->address_data = json_encode($shippingAddress);
    	$order->payment_type = $paymentType;
    	$order->payment_method = $payment_method;
    	$order->payment_id = $payment_id;
    	$order->created_at = Carbon::now();

    	if ($order->save()) {
    		$orderIdBuild = $order->id.mt_rand(10, 9999);
    		Order::where('id', $order->id)->update(['order_id'=>$orderIdBuild]);

    		//delete cart items
    		Cart::where('user_id', Auth::user()->id)->delete();

    		//forgot coupon session data
    		\Session::forget('applied_coupon_data');
    		return redirect("/customer/account?data=orders")->with('orderStatusSuccess', $orderIdBuild);
    	}

    	if ($paymentType === "PAID" && $request->p_transaction_id != '') {
    		return redirect()->route("checkout.init")->with("error", 'Internal server error | please contact administration for further help with this transaction ID : '.$request->p_transaction_id);
    	}else{
    		return redirect()->route("checkout.init")->with("error", 'Internal server error | please contact administration for further help');
    	}
    }



    //order actions
    public function order_actions($orderID, $actionType){
        $data = Order::where(['id'=>decrypt($orderID), "user_id"=>Auth::user()->id])->first();

        if (!$data) {
            return abort(404);
        }

        if (decrypt($actionType) === "Cancelled") {
            if ($data->status !== "Pending") {
                return redirect()->back()->with("error", "Order already ".$data->status);
            }

            $data->update([
                "status"=>decrypt($actionType)
            ]);
            
            //notify admin
            Notification::insert([
                "for"=>"admin",
                "notification_from"=>"User",
                "message"=>"Order ".decrypt($actionType)." by customer. Order ID #".$data->order_id,
                "url"=>route("admin.orders.show", encrypt($data->id)),
                "created_at"=>Carbon::now()
            ]);

            return redirect()->back()->with("success", "Order ".decrypt($actionType));
        }

        if (decrypt($actionType) === "SoftDelete") {
            $data->delete();
            return redirect()->back()->with("success", "Order record deleted");      
        }
    }

    
}
