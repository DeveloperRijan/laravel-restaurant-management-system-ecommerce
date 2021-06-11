<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\CustomerAddress;
use Carbon\Carbon;
use App\Models\Chat;
use App\Models\SupportTicket;
use Auth;

class CustomerAccountController extends Controller
{
    public function account(Request $request){
        if ($request->data === "orders") {
            return $this->getOrders($request);
        }

        if ($request->data === "support") {
            $tickets = SupportTicket::where('user_id', Auth::user()->id)->orderBy("created_at", "DESC")->get();
            return view("frontendViews.user.account.account", compact('tickets'));
        }

    	return view("frontendViews.user.account.account");
    }


    //customer orders
    private function getOrders($request){
        if ($request->id != '') {
            $order = Order::where(['id'=>decrypt($request->id), 'user_id'=>Auth::user()->id])->with('get_payment')->first();
            if (!$order) {
                return abort(404);
            }
            return view("frontendViews.user.account.account", compact('order'));
        }

        $orders = Order::where('user_id', Auth::user()->id)->orderBy("created_at", "DESC")->get();
        return view("frontendViews.user.account.account", compact('orders'));
    }

    public function add_address(Request $request){
    	$validation = Validator::make($request->all(), [
            'nick_name'=>'required|string|max:99',
            'mobile_number'=>'required|numeric|digits:'.\Config::get('constants.PHONE_NUM_LENGTH'),
            'address_line_1'=>'required|string|max:250',
            'address_line_2'=>'nullable|string|max:250',
            'city'=>'required|string|max:99',
            'post_code'=>'required|string|max:99',
            'note'=>'required|string|max:500'
        ]);

    	if ($validation->fails()) {
            return response()->json([
                "msg"=>$validation->errors()->first()
            ], 422);
        }

        //check nick is unique for this user
        if (CustomerAddress::where(["user_id"=>Auth::user()->id, "nick_name"=>$request->nick_name])->exists()) {
            return response()->json([
                "msg"=>"The nick name already you have, please try new one"
            ], 422);
        }
            

        //add address
        $address = new CustomerAddress([
        	"user_id"=>Auth::user()->id,
        	"nick_name"=>$request->nick_name,
        	"mobile_number"=>$request->mobile_number,
        	"address_line_1"=>$request->address_line_1,
        	"address_line_2"=>$request->address_line_2,
        	"city"=>$request->city,
        	"post_code"=>$request->post_code,
        	"note"=>$request->note,
        	"created_at"=>Carbon::now()
        ]);

        if ($address->save()) {
        	return response()->json([
                'success'=>true, 
                'msg'=>"Address Added",
                'data'=>['html_content'=>false]
            ], 200);
        }
        return response()->json([
            "msg"=>"Internal server error | please try again later"
        ], 422);

    }




    public function update_address(Request $request){
        $this->validate($request, [
            'nick_name'=>'required|string|max:99',
            'mobile_number'=>'required|numeric|digits:'.\Config::get('constants.PHONE_NUM_LENGTH'),
            'address_line_1'=>'required|string|max:250',
            'address_line_2'=>'nullable|string|max:250',
            'city'=>'required|string|max:99',
            'post_code'=>'required|string|max:99',
            'note'=>'required|string|max:500'
        ]);


        //add address
        $addressOldData = CustomerAddress::where(['id'=>decrypt($request->addressID), "user_id"=>Auth::user()->id])->first();
        if (!$addressOldData) {
            return redirect()->back()->with("error", "Address Not Found");
        }

        //check nick is unique for this user
        if (CustomerAddress::where([
            ["id", "!=", $addressOldData->id],
            ["user_id", "=", Auth::user()->id], 
            ["nick_name", "=", $request->nick_name]
        ])->exists()) {
            return redirect()->back()->with("error", "The nick name already you have, please try new one");
        }

        $address =  CustomerAddress::where('id', $addressOldData->id)->update([
            //"user_id"=>Auth::user()->id,
            "nick_name"=>$request->nick_name,
            "mobile_number"=>$request->mobile_number,
            "address_line_1"=>$request->address_line_1,
            "address_line_2"=>$request->address_line_2,
            "city"=>$request->city,
            "post_code"=>$request->post_code,
            "note"=>$request->note,
            "updated_at"=>Carbon::now()
        ]);

        return redirect()->back()->with("success", "Address Updated Successfully");
    }
}
