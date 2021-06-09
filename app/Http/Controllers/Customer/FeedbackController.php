<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Feedback;
use Carbon\Carbon;
use Auth;

class FeedbackController extends Controller
{
    //like_item product
    public function feedback_post(Request $request){
        if (!Auth::check()) {
            return response()->json(['msg'=>"Invalid Access | Please login to post your feedback"], 422);
        }


        if (Auth::user()->type === "Admin" || Auth::user()->type === "Kitchen Staff") {
            return response()->json(['msg'=>"SORRY - Only customer/staff can perform this action-  Thanks"], 422);
        }

        $data = Product::where('id', decrypt($request->productID))->first();
        if (!$data) {
            return response()->json(['msg'=>"Product Not Found"], 422);
        }

        //check already feedback
        $exist = Feedback::where([
            'user_id'=>Auth::user()->id,
            'product_id'=>$data->id
        ])->first();

        if ($exist) {
            return response()->json(['msg'=>"You already liked!"], 422);
        }

        $cart = new Feedback([
            "user_id"=>Auth::user()->id,//Customer ID
            "product_id"=>$data->id,
            "created_at"=>Carbon::now()
        ]);

        if ($cart->save()) {
        	$data->update(['total_feedback'=>($data->total_feedback + 1)]);
            return response()->json("Thank you for your feedback!", 200);
        }
        return response()->json(["msg"=>"Internal server error | please try again later."], 422);
    }
}
