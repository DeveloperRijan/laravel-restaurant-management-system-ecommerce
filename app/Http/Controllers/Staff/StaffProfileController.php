<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Designation;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Carbon\Carbon;

class StaffProfileController extends Controller
{
    public function profile_update(Request $request)
    {
        //update staff user only
        $validation = Validator::make($request->all(), [
            'name'=>'required|string|max:60',
            'email'=>'required|string|email|max:99|unique:users,email,'.Auth::user()->id,
            'phone'=>'required|numeric|digits:'.\Config::get('constants.PHONE_NUM_LENGTH'),
            'code'=>'required|string|max:99|unique:users,code,'.Auth::user()->id,
            'company_name'=>'required|string|max:99',
            'address_line_one'=>'required|string|max:150',
            'address_line_two'=>'nullable|string|max:150',
            'city'=>'required|string|max:50',
            'state'=>'required|string|max:50',
            'can_order_any_time'=>'required|string|in:Yes,No',
            'designation'=>'required|numeric'
        ]);

        if ($validation->fails()) {
            return redirect()->back()->with('error', $validation->errors()->first());
        }

        if ($request->can_order_any_time === "Yes") {
            $validation = Validator::make($request->all(), [
                'start_time'=>'required|date_format:H:i',
                'end_time'=>'required|date_format:H:i|after:start_time',
                'start_day'=>'required|string|in:'.implode(",", \Config::get("constants.WEEK_DAYS")),
                'end_day'=>'required|string|in:'.implode(",", \Config::get("constants.WEEK_DAYS")),
            ]);
        }

        //validate designation
        $designation = Designation::where('id', $request->designation)->first();
        if (!$designation) {
            return redirect()->back()->with('error', "Invalid Designation Selected");
        }
        
        $currentData = User::where([
            "id"=>Auth::user()->id,
            "type"=>"Staff"
        ])->first();

        if (!$currentData) {
            return redirect()->back()->with('error', "The user account not found");
        }

        $currentData->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'code'=>$request->code,
            'company_name'=>$request->company_name,
            'address_line_one'=>$request->address_line_one,
            'address_line_two'=>$request->address_line_two,
            'city'=>$request->city,
            'state'=>$request->state,
            'can_order_any_time'=>$request->can_order_any_time,
            'start_time'=>$request->start_time,
            'end_time'=>$request->end_time,
            'start_day'=>$request->start_day,
            'end_day'=>$request->end_day,
            'designation_id'=>$designation->id,
            'status'=>$currentData->status,
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        return redirect()->back()->with('success', "Data Updated");
    }


    public function pass_update_form(){
        return view("ks_panel.profile.password");
    }

    //change password
    public function password_update(Request $request){
        $this->validate($request, [
            'current_password'=>'required|min:8',
            'password'=>'required|string|min:8|max:16|confirmed'
        ]);


        $currentPass = $request->current_password;
        $new_password = $request->password;

        //First Check old password matched or not
        $match_current_pass = $this->check_old_pass($currentPass); 

        if ($match_current_pass == false) {
            return redirect()->back()->with('error', "Current Password didn't match.");
        }

        //Update Password            
        $updated = User::where(['id'=>Auth::user()->id, 'type'=>"Staff"])
                    ->update([
                        'password'=>Hash::make($new_password)
                    ]);
        
        if ($updated == true) {
            Auth::logout();
            return redirect('/staff')->with('sw_alert_session_success', "Password Updated Successfully");
        }
        return redirect()->back()->with('error', "Internal Server Error | Please try again later.");
    }


    //check_old_pass
    private function check_old_pass($current_pass){
        $authUserPass = Auth::user()->password;

        if (Hash::check($current_pass, $authUserPass)) {
            return true;
        }else{
            return false;
        }
    }
}
