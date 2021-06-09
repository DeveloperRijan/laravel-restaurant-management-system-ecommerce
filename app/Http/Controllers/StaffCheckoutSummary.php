<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryCharge;
use App\Models\Cart;
use App\Models\StaffBatchCoupon;
use App\Models\BatchCoupon;
use App\Models\Product;
use Auth;

class StaffCheckoutSummary extends Controller
{
    private $products;
    private $summary;
    private $couponAppliedResponse;

    /*
	@param $productID must be product id of Staff type
	@before calling this method - should validate product is exists
    */
    public function getCheckoutSummary($productID, $coupon){
        $this->products = NULL;
        $this->summary['sub_total']  = 0;
        $this->summary['totalItemsDiscountAmount']  = 0;
        $this->summary['delivery_charge']  = [];
        $this->summary['grand_total']  = 0;
        $this->couponAppliedResponse  = NULL;

       

    	$product = Product::where('id', $productID)->first();


		//get total amount with qty * price
        $total_amount = number_format($product->price, 2, '.', '');

        //calculate sub & grand total
		$this->summary['sub_total'] += $total_amount;
        $this->summary['grand_total'] += $total_amount;

        $discount_percent = NULL;
        $total_discount_amount = number_format($product->discount_price, 2, '.', '');
        $after_minus_total_discount_amount_amount = NULL;

		if ($product->discount_price > 0) {
			$this->summary['totalItemsDiscountAmount'] += $product->discount_price;

            //calculate dis. percent
            $discount_percent = number_format(($product->discount_price / 100), 2, '.', '');
            
            //decut discount amounts
            $after_minus_total_discount_amount_amount = number_format(($total_amount - $product->discount_price), 2, '.', '');//multiply with qty for each item total discount
            $this->summary['sub_total'] = number_format(($this->summary['sub_total'] - $total_discount_amount), 2, '.', '');//multiply with qty for each item total discount
            $this->summary['grand_total'] = number_format(($this->summary['grand_total'] - $total_discount_amount), 2, '.', '');//multiply with qty for each item total discount
            
		}


        //set first image of product images
        $productImg = json_decode($product->images, true);
        $productImg = $productImg[0];
       
       //organize data
        $this->products[] = [
            "product"=>[
                "id"=>$product->id,
                "type"=>$product->type,
                "item_type"=>$product->item_type,
                "title"=>$product->title,
                "slug"=>$product->slug,
                "image"=>$productImg,
                "price"=>$product->price,
                "discount_price"=>$product->discount_price,
                "item_discount_percent"=>$discount_percent,
                "total_amount_multiply_qty"=>$total_amount,
                "total_discount_amount"=>number_format($product->discount_price, 2, '.', ''),
                "total_amount_minus_total_dis"=>$after_minus_total_discount_amount_amount,
            ]
        ];
    	


        //if customer enter any coupon code then
        if ($product->item_type === "Meal") {
            if ($coupon === "use") {
                $this->couponAppliedResponse = $this->processCoupon();
            }else{
                \Session::forget("is_batch_coupon_applied");
            }
        }else{
            \Session::forget("is_batch_coupon_applied");
        }
        


        //add delivery charge if applicable
        // $deliveryCharge = DeliveryCharge::where('type', 'General')->first();
        // if ($deliveryCharge && $deliveryCharge->status === "Active") {
        //     $this->summary['delivery_charge'] = [
        //         "charge_amount"=>$deliveryCharge->charge_amount,
        //         "type"=>$deliveryCharge->type
        //     ];
        //     $this->summary['grand_total'] = number_format(($this->summary['grand_total'] + $deliveryCharge->charge_amount), 2, '.', '');
        // }else{
            $this->summary['delivery_charge'] = [
                "charge_amount"=>"Free"
            ];
        //}

        //decimal figuare the sub total amount
        $this->summary['sub_total'] = number_format($this->summary['sub_total'], 2, '.', '');
        //round figuare the grand total amount
        $this->summary['grand_total'] = round($this->summary['grand_total']);
        
        //push into single array
        $data = [];
        $data = [
            "products"=>$this->products,
            "summary"=>$this->summary,
            'couponAppliedResponse'=>$this->couponAppliedResponse
        ];
        
        return $data;
        
    }


    private function processCoupon(){
        if (!Auth::check()) {
            $response = [];
            $response["is_applied"] = false;
            $response["msg"] = "Please login to use coupon";
            return $response;
        }
        $myCoupon = StaffBatchCoupon::where("user_id", Auth::user()->id)->first();
        
        //if not active
        if (!$myCoupon) {
            $response = [];
            $response["is_applied"] = false;
            $response["msg"] = "No coupon found";
            return $response;
        }


        //if already used the limit
        if (!$myCoupon->remaining_coupons  > 0) {
            $response = [];
            $response["is_applied"] = false;
            $response["msg"] = "Remaining Coupon 0";
            return $response;
        }

        //applied success
        $response = [];
        
        //get coupon discount amount
        $discountPercent = 0;

        $specialCoupon = BatchCoupon::where('type', "Special")->first();
        $generalCoupon = BatchCoupon::where('type', "General")->first();

        if (Auth::user()->city == $specialCoupon->city && Auth::user()->designation_id == $specialCoupon->designation_id) {
            //special discount
            $discountPercent = $specialCoupon->coupon_percent;
            $response["coupon_discount_type"] = "Special";
            $response["coupon_discount_percent"] = $specialCoupon->coupon_percent;
        }else{
            $discountPercent = $generalCoupon->coupon_percent;
            $response["coupon_discount_type"] = "General";
            $response["coupon_discount_percent"] = $generalCoupon->coupon_percent;
        }


        //deduct coupon discount price from grand total
        $coupon_dis_amount = ($discountPercent / 100)  * $this->summary['grand_total'];
        $this->summary['grand_total'] = $this->summary['grand_total'] - $coupon_dis_amount;
        $response["coupon_discount_amount"] = $coupon_dis_amount;
        

        $response["is_applied"] = true;
        $response["msg"] = $discountPercent."% Coupon Applied";
        
        \Session::forget("is_batch_coupon_applied");
        \Session::put("is_batch_coupon_applied", "yes");
        return $response;
    }
}
