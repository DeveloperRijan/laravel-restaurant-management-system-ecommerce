<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryCharge;
use App\Models\Cart;
use App\Models\Coupon;
use Auth;

class CheckoutSummary extends Controller
{
    private $products;
    private $summary;
    private $couponAppliedResponse;


    public function getCheckoutSummary($couponCode=NULL){
        $this->products = NULL;
        $this->summary['sub_total']  = 0;
        $this->summary['totalItemsDiscountAmount']  = 0;
        $this->summary['delivery_charge']  = [];
        $this->summary['grand_total']  = 0;
        $this->couponAppliedResponse  = NULL;

       

    	$cartItems = Cart::where('user_id', Auth::user()->id)->orderBy('created_at', "DESC")
    					->with("get_product")
    					->get();
    	if ($cartItems->isEmpty()) {
    		return NULL;
    	}



        //check data and process rest
    	foreach ($cartItems as $key => $item) {
    		if ($item->get_product) {

                //if product is available then else sold out
                if ($item->get_product->stock_status === "Available" && $item->get_product->type === "Main") {
                    //get total amount with qty * price
                    $total_amount = number_format(($item->get_product->price *  $item->qty), 2, '.', '');

                    //calculate sub & grand total
                    $this->summary['sub_total'] += $total_amount;
                    $this->summary['grand_total'] += $total_amount;

                    $discount_percent = NULL;
                    $total_discount_amount = number_format(($item->get_product->discount_price * $item->qty), 2, '.', '');
                    $after_minus_total_discount_amount_amount = NULL;

                    if ($item->get_product->discount_price > 0) {
                        $this->summary['totalItemsDiscountAmount'] += $item->get_product->discount_price;

                        //calculate dis. percent
                        $discount_percent = number_format(($item->get_product->discount_price / 100), 2, '.', '');
                        
                        //decut discount amounts
                        $after_minus_total_discount_amount_amount = number_format($total_amount - ($item->get_product->discount_price * $item->qty), 2, '.', '');//multiply with qty for each item total discount
                        $this->summary['sub_total'] = number_format(($this->summary['sub_total'] - $total_discount_amount), 2, '.', '');//multiply with qty for each item total discount
                        $this->summary['grand_total'] = number_format(($this->summary['grand_total'] - $total_discount_amount), 2, '.', '');//multiply with qty for each item total discount
                        
                    }


                    //set first image of product images
                    $productImg = json_decode($item->get_product->images, true);
                    $productImg = $productImg[0];
                   
                   //organize data
                    $this->products[] = [
                        "cart"=>[
                            "id"=>$item->id,
                            "user_id"=>$item->user_id,
                            "product_id"=>$item->product_id,
                            "qty"=>$item->qty,
                        ],
                        "product"=>[
                            "id"=>$item->get_product->id,
                            "title"=>$item->get_product->title,
                            "slug"=>$item->get_product->slug,
                            "image"=>$productImg,
                            "price"=>$item->get_product->price,
                            "discount_price"=>$item->get_product->discount_price,
                            "item_discount_percent"=>$discount_percent,
                            "total_amount_multiply_qty"=>$total_amount,
                            "total_discount_amount"=>number_format(($item->get_product->discount_price * $item->qty), 2, '.', ''),
                            "total_amount_minus_total_dis"=>$after_minus_total_discount_amount_amount,
                        ]
                    ];
                }else{
                    Cart::where('id', $item->id)->delete();
                    \Session::flash("checkout_some_cart_items_deleted", "Some items have been removed from your cart due to ".$item->get_product->stock_status."/".$item->get_product->type." or might be not available!");
                }
    		
            }else{
                Cart::where('id', $item->id)->delete();
                \Session::flash("checkout_some_cart_items_deleted", "One or more items have been remove from your cart due to the product is unavailable now!");
            }
    	}


        //if customer enter any coupon code then
        if ($couponCode !== NULL) {
            if ($couponCode === "remove") {
                \Session::forget("applied_coupon_data");
            }else{
                $this->couponAppliedResponse = $this->processCoupon($couponCode);
            }
        }else{
            \Session::forget("applied_coupon_data");
        }


        //add delivery charge if applicable
        $deliveryCharge = DeliveryCharge::where('type', 'General')->first();
        if ($deliveryCharge && $deliveryCharge->status === "Active") {
            $this->summary['delivery_charge'] = [
                "charge_amount"=>$deliveryCharge->charge_amount,
                "type"=>$deliveryCharge->type
            ];
            $this->summary['grand_total'] = number_format(($this->summary['grand_total'] + $deliveryCharge->charge_amount), 2, '.', '');
        }else{
            $this->summary['delivery_charge'] = [
                "charge_amount"=>"Free"
            ];
        }

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


    private function processCoupon($coupon_code){
        $couponData = Coupon::where("coupon_code", $coupon_code)->first();

        //if not found
        if (!$couponData) {
            $response = [];
            $response["is_applied"] = false;
            $response["msg"] = "Invalid Coupon Code ! Not Found";
            $response["requested_coupon_code"] = $coupon_code;

            return $response;
        }
        
        //if not active
        if ($couponData->status !== "Active") {
            $response = [];
            $response["is_applied"] = false;
            $response["msg"] = "The coupon already ".$couponData->status;
            $response["requested_coupon_code"] = $coupon_code;

            return $response;
        }

        //if expired or not
        if (date("Y-m-d") > date("Y-m-d", strtotime($couponData->expire_date))) {
            $couponData->update(['status'=>"Expired"]);
            
            $response = [];
            $response["is_applied"] = false;
            $response["msg"] = "The coupon already ".$couponData->status;
            $response["requested_coupon_code"] = $coupon_code;

            return $response;
        }

        //if already used the limit
        if ($couponData->number_of_coupon != NULL) {
            if ($couponData->number_of_coupon == $couponData->coupon_used) {
                $couponData->update(['status'=>"Expired"]);

                $response = [];
                $response["is_applied"] = false;
                $response["msg"] = "The coupon already Used/Expired";
                $response["requested_coupon_code"] = $coupon_code;

                return $response;
            }
        }

        //applied success
        $response = [];
        $response["is_applied"] = true;
        $response["msg"] = "Coupon Applied (-".$couponData->coupon_discount."%)";
        $response["requested_coupon_code"] = $coupon_code;
        
        


        //deduct coupon discount price from grand total
        $coupon_dis_amount = ($couponData->coupon_discount / 100)  * $this->summary['grand_total'];
        $this->summary['grand_total'] = $this->summary['grand_total'] - $coupon_dis_amount;
        $response["coupon_discount_amount"] = $coupon_dis_amount;

        \Session::forget("applied_coupon_data");
        \Session::put("applied_coupon_data", $response);
        return $response;
    }
}
