<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\BatchCoupon;
use App\Models\BatchCouponPurchaseHistory;
use App\Models\StaffBatchCoupon;
use App\Models\Designation;
use App\Models\User;
use Carbon\Carbon;

class BatchCouponController extends Controller
{
    public function batch_coupon_setting(){
    	$designations = Designation::orderBy("title", "ASC")->get();
    	//$cities = User::where('city', '!=', NULL)->distinct("city")->pluck("city")->toArray();

    	$specialCoupon = BatchCoupon::where('type', "Special")->first();
    	$generalCoupon = BatchCoupon::where('type', "General")->first();
    	return view("backendViews.staffs.coupon.setting", compact('designations', 'specialCoupon', 'generalCoupon'));
    }


    //old system
    // public function batch_coupon_setting_post(Request $request){
    // 	$validations = Validator::make($request->all(), [
    // 		"special_designation"=>"required|numeric",
    // 		"special_10_batch"=>"required",
    // 		"special_20_batch"=>"required",

    // 		"general_10_batch"=>"required",
    // 		"general_20_batch"=>"required"
    // 	]);

    // 	if ($validations->fails()) {
    // 		return redirect()->back()->with("error", $validations->errors()->first());
    // 	}

    // 	//validate special_designation id
    // 	$designationData = Designation::where('id', $request->special_designation)->first();
    // 	if (!$designationData) {
    // 		return redirect()->back()->with("error", "Designation not found");
    // 	}

    // 	$specialCoupon = BatchCoupon::where('type', "Special")->first();
    // 	$generalCoupon = BatchCoupon::where('type', "General")->first();

    // 	//sepcial city
    // 	$specialCities = \Config::get("constants.SEPECIAL_CITIES");

    // 	if ($specialCoupon) {
    // 		//update 
    // 		$specialCoupon->update([
    // 			"designation_id"=>$request->special_designation,
    // 			"batch_10"=>$request->special_10_batch,
    // 			"batch_20"=>$request->special_20_batch,
    // 			"updated_at"=>Carbon::now()
    // 		]);

    // 	}else{
    // 		//insert
    // 		$batchSave = new BatchCoupon([
    // 			"type"=>"Special",
    // 			"city"=>$specialCities[0],
    // 			"designation_id"=>$request->special_designation,
    // 			"batch_10"=>$request->special_10_batch,
    // 			"batch_20"=>$request->special_20_batch,
    // 			"created_at"=>Carbon::now()
    // 		]);
    // 		if (!$batchSave->save()) {
    // 			return redirect()->back()->with("error", "Something wrong");
    // 		}
    // 	}


    // 	//general
    // 	if ($generalCoupon) {
    // 		//update 
    // 		$generalCoupon->update([
    // 			"designation_id"=>NULL,
    // 			"batch_10"=>$request->general_10_batch,
    // 			"batch_20"=>$request->general_20_batch,
    // 			"updated_at"=>Carbon::now()
    // 		]);
    // 	}else{
    // 		//insert
    // 		$batchSaveG = new BatchCoupon([
    // 			"type"=>"General",
    // 			"city"=>"All",
    // 			"designation_id"=>NULL,
    // 			"batch_10"=>$request->general_10_batch,
    // 			"batch_20"=>$request->general_20_batch,
    // 			"created_at"=>Carbon::now()
    // 		]);
    // 		if (!$batchSaveG->save()) {
    // 			return redirect()->back()->with("error", "Something wrong");
    // 		}
    // 	}

    // 	return redirect()->back()->with("success", "Setting Data Saved");
    // }

    //new system
    public function batch_coupon_setting_post(Request $request){
     $validations = Validator::make($request->all(), [
         "special_designation"=>"required|numeric",
         "special_coupon_percent"=>"required",
         "general_coupon_percent"=>"required"
     ]);

     if ($validations->fails()) {
         return redirect()->back()->with("error", $validations->errors()->first());
     }

     //validate special_designation id
     $designationData = Designation::where('id', $request->special_designation)->first();
     if (!$designationData) {
         return redirect()->back()->with("error", "Designation not found");
     }

     $specialCoupon = BatchCoupon::where('type', "Special")->first();
     $generalCoupon = BatchCoupon::where('type', "General")->first();

     //sepcial city
     $specialCities = \Config::get("constants.SEPECIAL_CITIES");

     if ($specialCoupon) {
         //update 
         $specialCoupon->update([
             "designation_id"=>$request->special_designation,
             "coupon_percent"=>$request->special_coupon_percent,
             "updated_at"=>Carbon::now()
         ]);

     }else{
         //insert
         $batchSave = new BatchCoupon([
             "type"=>"Special",
             "city"=>$specialCities[0],
             "designation_id"=>$request->special_designation,
             "coupon_percent"=>$request->special_10_batch,
             "created_at"=>Carbon::now()
         ]);
         if (!$batchSave->save()) {
             return redirect()->back()->with("error", "Something wrong");
         }
     }


     //general
     if ($generalCoupon) {
         //update 
         $generalCoupon->update([
             "designation_id"=>NULL,
             "coupon_percent"=>$request->general_coupon_percent,
             "updated_at"=>Carbon::now()
         ]);
     }else{
         //insert
         $batchSaveG = new BatchCoupon([
             "type"=>"General",
             "city"=>"All",
             "designation_id"=>NULL,
             "coupon_percent"=>$request->general_coupon_percent,
             "created_at"=>Carbon::now()
         ]);
         if (!$batchSaveG->save()) {
             return redirect()->back()->with("error", "Something wrong");
         }
     }

     return redirect()->back()->with("success", "Setting Data Saved");
    }


    //batch coupon purchase history
    public function add_batch_coupon_form(){
        $staffs = User::where(["type"=>"Staff", "status"=>"Active"])->orderBy("name", "DESC")->with("get_staff_coupon")->get();
        return view("backendViews.batchCouponAdd.add", compact("staffs"));
    }

    //add batch coupon
    public function add_batch_coupon_post(Request $request){
        $validation = Validator::make($request->all(), [
            'staffID'=>'required|string',
            'batch'=>'required|numeric|in:10,20'
        ]);

        if ($validation->fails()) {
            return response()->json(["msg"=>$validation->errors()->first()], 422);
        }

        //validate staff id
        $staff = User::where(["id"=>decrypt($request->staffID), "status"=>"Active"])->first();
        if (!$staff) {
            return response()->json(["msg"=>"Staff Not Found"], 422);
        }

        //get current coupon
        $currentCoupon = StaffBatchCoupon::where('user_id', $staff->id)->first();

        if ($currentCoupon) {
            //update
            $currentCoupon->update([
                "total_coupons"=>($currentCoupon->total_coupons + $request->batch),
                "remaining_coupons"=>($currentCoupon->remaining_coupons + $request->batch),
                "updated_at"=>Carbon::now()
            ]);

            //save history
            BatchCouponPurchaseHistory::insert([
                "user_id"=>$staff->id,
                "batch"=>$request->batch,
                "created_at"=>Carbon::now()
            ]);

            return response()->json([
                'success'=>true, 
                'msg'=>"Batch Coupon Added",
                'data'=>['html_content'=>false]
            ], 200);
        }

        //insert
        StaffBatchCoupon::insert([
            "user_id"=>$staff->id,
            "total_coupons"=>$request->batch,
            "remaining_coupons"=>$request->batch,
            "created_at"=>Carbon::now()
        ]);
        //save history
        BatchCouponPurchaseHistory::insert([
            "user_id"=>$staff->id,
            "batch"=>$request->batch,
            "created_at"=>Carbon::now()
        ]);

        return response()->json([
            'success'=>true, 
            'msg'=>"Batch Coupon Added",
            'data'=>['html_content'=>false]
        ], 200);
    }

}
