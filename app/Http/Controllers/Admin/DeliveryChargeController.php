<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryCharge;
use Carbon\Carbon;

class DeliveryChargeController extends Controller
{
    public function index(){
    	$data = DeliveryCharge::first();
    	return view("backendViews.delivery.charge", compact('data'));
    }

    public function store(Request $request){
    	$this->validate($request, [
            'charge_amount'=>'required|min:1',
            'status'=>'required|string|in:Active,Inactive'
        ]);


        $data = DeliveryCharge::first();
        if ($data) {
            //update
            $updated = $data->update([
                'charge_amount'=>$request->charge_amount,
                'status'=>$request->status,
                'updated_at'=>Carbon::now()
            ]);

            return redirect()->back()->with('success', "Data Update");
        }

        //else insert
        $insert = new DeliveryCharge([
            'charge_amount'=>$request->charge_amount,
            'status'=>$request->status,
            'created_at'=>Carbon::now()
        ]);

        if ($insert->save()) {
            return redirect()->back()->with('success', "Delivery Charge Set Successfully");
        }
        return redirect()->back()->with('error', "Internal Server Error | Please try again later.");
    }
}
