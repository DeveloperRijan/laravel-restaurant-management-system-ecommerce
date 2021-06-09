<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Auth;


class CustomerProfileController extends Controller
{

    public function profile_update(Request $request)
    {
        //update profile
        $this->validate($request, [
            'name'=>'required|string|max:60',
            'email'=>'required|string|email|max:99|unique:users,email,'.Auth::user()->id,
            'phone'=>'required|numeric|digits:'.\Config::get('constants.PHONE_NUM_LENGTH'),
        ]);


        $updated = User::where(['id'=>Auth::user()->id, 'type'=>"Customer"])
                ->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'updated_at'=>Carbon::now()
                ]);

        if ($updated == true) {
            return redirect()->back()->with('success', "Profile Data Updated");
        }
        return redirect()->back()->with('error', "Internal Server Error | Please try again later.");
    }


    public function pass_update_form(){
        return view("backendViews.profile.password");
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
        $updated = User::where(['id'=>Auth::user()->id, 'type'=>"Customer"])
                    ->update([
                        'password'=>Hash::make($new_password)
                    ]);
        
        if ($updated == true) {
            Auth::logout();
            return redirect()->route('root_page')->with('sw_alert_session_success', "Password Updated Successfully");
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
