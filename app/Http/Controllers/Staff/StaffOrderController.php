<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\StaffCheckoutSummary;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Category;
use App\Models\StaffAddress;
use App\Models\StaffAllowedDeliveryOrder;
use App\Models\Order;
use App\Models\StaffBatchCoupon;
use Carbon\Carbon;
use Auth;

class StaffOrderController extends Controller
{
    //order now
	public function order_now(Request $request){
		//check is auth the if not staff
        if (Auth::check() && Auth::user()->type !== "Staff") {
            return redirect()->route('root_page')->with('sw_alert_session_error', "Only Staffs have access permission to the staff order page - Thanks");
        }

		//payment step
		if ($request->step === "payment") {
			return $this->processPaymentStep($request);
		}


		//address step
		if ($request->step === "address") {
			if (!Auth::check()) {
				return redirect()->back()->with("error", "Please login in order to forward next");
			}
			return $this->processShippingAddressStep($request);
		}

		$allItems = Product::where(["type"=>"Staff", "status"=>"Active"])->orderBy("title", "ASC")->get();


		//ajax checkout summary rendering
		if (\Request::ajax()) {
			//ajax request
			if ($request->product_id != '') {
				$selectedItem = Product::where(["id"=>decrypt($request->product_id)])->first();
				if (!$selectedItem) {
					return response()->json(["msg"=>"The item you have selected not found"], 422);
				}

				//validate product
				if (!$selectedItem) {
		          return response()->json(["msg"=>"The item you have selected not found"], 422);
		        }
		        if ($selectedItem->status !== "Active") {
		          return response()->json(["msg"=>"The item you have selected is unavailable"], 422);
		        }
		        if ($selectedItem->type !== "Staff") {
		          return response()->json(["msg"=>"The item you have selected not for you!"], 422);
		        }
		        if ($selectedItem->stock_status !== "Available") {
		          return response()->json(["msg"=>"The item you have selected is already Sold Out!"], 422);
		        }

		        //if validation pass
				if ($request->has('coupon') && $request->coupon != '') {
					//get checkout summary
					$obj = new StaffCheckoutSummary();
					$data = $obj->getCheckoutSummary($selectedItem->id, $request->coupon);
					return view("frontendViews.staff.partials.checkout.checkout_data", compact('data', 'selectedItem', 'allItems'))->render();
				}

				//get checkout summary
				$obj = new StaffCheckoutSummary();
				$data = $obj->getCheckoutSummary($selectedItem->id, false);
				return view("frontendViews.staff.partials.checkout.checkout_data", compact('data', 'selectedItem', 'allItems'))->render();
			}
			return response()->json(["msg"=>"Product ID Required"], 422);
		}


		//without ajax intial checkout page loading
		if ($request->product_id != '') {
			$selectedItem = Product::where(["id"=>decrypt($request->product_id), "type"=>"Staff", "status"=>"Active", "stock_status"=>"Available"])->first();
			
			if (!$selectedItem) {
	          return abort(404, "The item you have selected not found or might be Sold Out");
	        }

			if ($request->has('coupon') && $request->coupon != '') {
				//get checkout summary
				$obj = new StaffCheckoutSummary();
				$data = $obj->getCheckoutSummary($selectedItem->id, $request->coupon);
				return view("frontendViews.staff.order", compact('data', 'selectedItem', 'allItems'));
			}

			//get checkout summary
			$obj = new StaffCheckoutSummary();
			$data = $obj->getCheckoutSummary($selectedItem->id, false);
			return view("frontendViews.staff.order", compact('data', 'selectedItem', 'allItems'));
		}

		$selectedItem = NULL;
		return view("frontendViews.staff.order", compact('selectedItem', 'allItems'));
	}






	private function processShippingAddressStep($request){
		$validation = NULL;
		$validation = Validator::make($request->all(), [
			"product"=>"required|string",
			"delivery_time"=>"required|string|in:ASAP,Schedule",
			"delivery_type"=>"required|string|in:Collection,Delivery",
		]);

		if ($request->delivery_time === "Schedule") {
			$validation = Validator::make($request->all(), [
				"schedule_date"=>"required|date|date_format:Y-m-d",
				"schedule_time"=>"required|date_format:H:i"
			]);
		}
		if ($validation->fails()) {
			return redirect()->route("staff.order.page")->with("error", $validation->errors()->first());
		}

		//validate product
		$selectedItem = Product::where(["id"=>decrypt($request->product), "type"=>"Staff", "status"=>"Active", "stock_status"=>"Available"])->first();
		if (!$selectedItem) {
			return redirect()->route("staff.order.page")->with("error", "The item you have selected might be Sold Out or not available...");
		}

		//validate delivery type
		if (!StaffAllowedDeliveryOrder::where('code', Auth::user()->code)->exists()) {
			if ($request->delivery_type === "Delivery") {
				return redirect()->route("staff.order.page")->with("error", "You are not allowed to make order type Delivery, please select Collection.");
			}
		}

		//check time is not backdated
		if ($request->delivery_time === "Schedule") {
			$schedule_dl_date = $request->schedule_date." ".$request->schedule_time;
			$scheduleDeliveryTime = date("Y-m-d H:i", strtotime($schedule_dl_date));

			$currentMoment = Carbon::now();
			
			//if order can anytime so schedule order must be at least defined hrs later..
			//if (Auth::user()->can_order_any_time === "Yes") {
				$currentMoment = $currentMoment->addHours(\Config::get('constants.STAFF_SCHEDULE_ORDER_AT_LEAST_TIME'));;
				$currentTime = $currentMoment->format("Y-m-d H:i");

				//return $scheduleDeliveryTime." ".$currentTime;
				if ($scheduleDeliveryTime < $currentTime) {
					return redirect()->route("staff.order.page")->with("error", "SORRY - You have to at least ".\Config::get('constants.STAFF_SCHEDULE_ORDER_AT_LEAST_TIME'). " hours give us to delivery your schedule order, but you have selected delivery time : ".date("Y-m-d H:i A", strtotime($scheduleDeliveryTime)));
				}
			//}

			//must order between company allocated time
			//$start_day = Auth::user()->start_day;
			//$end_day = Auth::user()->end_day;

		}
		

		$is_batch_coupon_applied = false;
		if (\Session::has("is_batch_coupon_applied")) {
			$is_batch_coupon_applied = \Session::get("is_batch_coupon_applied");
		}

		//store all data in session
		if ($is_batch_coupon_applied === "yes") {
			$is_batch_coupon_applied = true;
		}

		$data = [];
		$data = [
			"product_id"=>$request->product,//encrypted
			"delivery_time"=>$request->delivery_time,
			"schedule_date"=>$request->schedule_date,
			"schedule_time"=>$request->schedule_time,
			"delivery_type"=>$request->delivery_type,
			"batch_coupon_applied"=>$is_batch_coupon_applied
		];

		\Session::forget("staff_checkout_item_details_step_data");
		\Session::put("staff_checkout_item_details_step_data", $data);

		return redirect("/staff/order?step=shipping_address");
	}






	private function processPaymentStep($request){
		if (!Auth::check()) {
			return abort(403, "Access denied");
		}
		if ($request->address == '') {
			return redirect()->route("staff.order.page")->with("error", "Shipping address missing...");
		}
		//check address id  valid
		$addressData = StaffAddress::where(["id"=>decrypt($request->address),  "user_id"=>Auth::user()->id])->first();
		if (!$addressData) {
			return redirect()->route("staff.order.page")->with("error", "Invalid shipping address | address not found");
		}

		//check session data has
		if (!\Session::has("staff_checkout_item_details_step_data")) {
			return abort(403, "No Checkout Item Details Data Found");
		}

		$staff_checkout_item_details = \Session::get("staff_checkout_item_details_step_data");

		//get checkout whole data
		$obj = new StaffCheckoutSummary();
		$data = [];
		if ($staff_checkout_item_details["batch_coupon_applied"] === true) {
			$data["checkout_summary"] = $obj->getCheckoutSummary(decrypt($staff_checkout_item_details["product_id"]), "use");
		}else{
			$data["checkout_summary"] = $obj->getCheckoutSummary(decrypt($staff_checkout_item_details["product_id"]), false);
		}
		$data["address_data"] = $addressData;
		unset($staff_checkout_item_details["product_id"]);
		unset($staff_checkout_item_details["batch_coupon_applied"]);

		$data["order_processing_data"] = $staff_checkout_item_details;

		\Session::forget("staff_checkout_item_details_step_data");
		\Session::forget("staff_checkout_whole_data");
		\Session::put("staff_checkout_whole_data", $data);

		return redirect("/staff/order?step=secure_payment");
	}






	//save the order
	public function order_save(Request $request){
		if (!\Session::has("staff_checkout_whole_data")) {
    		return redirect()->route("staff.order.page")->with("error", "SORRY - Something went wrong - no order data found, please contact administration for further support.");
    	}

    	if (decrypt($request->payment_type) === "cod") {
    		return $this->processOrder($request, "COD");
    	}

    	if (decrypt($request->payment_type) === "paid") {
    		return $this->processOrder($request, "PAID");
    	}

    	if (decrypt($request->payment_type) === "credit") {
    		return $this->processOrder($request, "CREDIT BALANCE");
    	}

    	return redirect()->route("staff.order.page")->with("error", "Invalid order payment type | Please contact administration for futher help!");
	}


	//process the order
	private function processOrder($request, $paymentType){
    	//update coupon used status
    	$checkOutWholeDataToOrder = \Session::get("staff_checkout_whole_data");
    	
    	//if credit balance order then
    	if ($paymentType === "CREDIT BALANCE") {
    		$staffCreditBalance = \App\Models\StaffCredit::where('user_id', \Auth::user()->id)->first();
    		if (!$staffCreditBalance) {
    			return redirect()->back()->with("error", "SORRY - You have to credit");
    		}

    		//check balance is enough to order
    		if ($staffCreditBalance->remaining_balance < $checkOutWholeDataToOrder['checkout_summary']['summary']['grand_total']) {
    			return redirect()->back()->with("error", "SORRY - You don't have enough credit balance.");
    		}

    		$staffCreditBalance->update([
    			"remaining_balance"=>($staffCreditBalance->remaining_balance - $checkOutWholeDataToOrder['checkout_summary']['summary']['grand_total'])
    		]);
    	}


    	$couponApplied = false;
    	if (isset($checkOutWholeDataToOrder["checkout_summary"]['couponAppliedResponse']) && $checkOutWholeDataToOrder["checkout_summary"]['couponAppliedResponse'] != null && $checkOutWholeDataToOrder['checkout_summary']['couponAppliedResponse']['is_applied'] === true) {
    		//now reduce coupon
    		$coupon = StaffBatchCoupon::where('user_id', Auth::user()->id)->first();
        	if ($coupon) {
        		$coupon->update(['remaining_coupons'=>($coupon->remaining_coupons-1)]);
        		$couponApplied = true;
        	}
    	}
        

        $shippingAddress = $checkOutWholeDataToOrder["address_data"];

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


    	unset($checkOutWholeDataToOrder["address_data"]);

    	$order = new Order();
    	$order->order_by = "Staff";
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

    		//forgot coupon session data
    		return redirect("/staff/account?data=orders")->with('staffOrderStatusSuccess', [
    			"orderID"=>$orderIdBuild,
    			"couponApplied"=>$couponApplied
    		]);
    	}

    	if ($paymentType === "PAID" && $request->p_transaction_id != '') {
    		return redirect()->route("staff.order.page")->with("error", 'Internal server error | please contact administration for further help with this transaction ID : '.$request->p_transaction_id);
    	}else{
    		return redirect()->route("staff.order.page")->with("error", 'Internal server error | please contact administration for further help');
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