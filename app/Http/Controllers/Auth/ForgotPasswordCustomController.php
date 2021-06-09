<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordResetOption;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordRecoveryEmail;
use Carbon\Carbon;
use Hash;

class ForgotPasswordCustomController extends Controller
{	
	public function __construct(){
		$this->middleware('guest')->except('logout');
	}


    //pass_reset_form
    public function pass_reset_form(Request $request){
        if ($request->userType == '') {
            return redirect()->route('login')->with("error", "Invalid Access");
        }
        return view('auth.password-reset-form', compact('request'));
    	
    }

    //send reset link
    public function send_reset_link(Request $request){
    	$this->validate($request, [
    		'email'=>'required|string|email|max:100',
            'userType'=>'required|string'
    	]);

        $data = NULL;
        $type = decrypt($request->userType);
        if ($type === "Admin") {
            $data = User::where(['email'=>$request->email, "type"=>'Admin'])->first();
        }elseif($type === "Customer"){
            $data = User::where(['email'=>$request->email, "type"=>'Customer'])->first();
        }elseif($type === "KitchenStaff"){
            $data = User::where(['email'=>$request->email, "type"=>'Kitchen Staff'])->first();
        }elseif($type === "Staff"){
            $data = User::where(['email'=>$request->email, "type"=>'Staff'])->first();
        }else{
            return redirect()->back()->withInput()->with('error', 'Invalid Request!');
        }
    	
    	if (!$data) {
    		return redirect()->back()->withInput()->with('error', 'SORRY - Account Not Found!');
    	}

    	//check old old data
    	$oldData = PasswordResetOption::where([
            'type'=>$type,
            'email'=>$request->email
        ])->first();

        $expire_at = Carbon::now()->addMinutes(30);
        $token = uniqid().mt_rand(10, 9999).uniqid();

    	if ($oldData) {
    		$oldData->update([
    			'token'=>$token,
    			'created_at'=>$expire_at
    		]);
    	}else{
    		//insert new
    		PasswordResetOption::insert([
    			'type'=>$type,
                'email'=>$request->email,
    			'token'=>$token,
    			'created_at'=>$expire_at
    		]);
    	}
    	

    	//get reset
    	$resetData = PasswordResetOption::where([
            'type'=>$type,
            'email'=>$request->email
        ])->first();

    	if (!$resetData) {
    		return redirect()->back()->with('error', 'Sorry- Something wrong, please try again later.');
    	}



        Mail::to($request->email)->send(new PasswordRecoveryEmail(
            $type, $data, $token, $request->email
         ));
    	

    	return redirect()->back()->with('success', 'Reset link has been sent to your email & will be expire within 30 minutes.');
    }



    //reset password post
    public function password_reset_post(Request $request){
        //return $request;
    	$this->validate($request, [
    		'userType'=>'required|string',
            'token'=>'required|string',
    		'email'=>'required|string',
    		'password'=>'required|string|min:8|max:33|confirmed',
    	]);

    	//validate token
        $userType = decrypt($request->userType);
    	$resetData = PasswordResetOption::where([
    		['type', '=', $userType],
            ['token', '=', $request->token],
    		['email', '=', decrypt($request->email)]
    	])->first();


        

    	if (!$resetData) {
            if ($userType === 'Admin') {
                return redirect()->route('admin.login')->with('error', 'SORRY - Reset Token or Email mismatch.');
            }elseif($userType === 'KitchenStaff'){
                return redirect()->route('ks.login.form')->with('error', 'SORRY - Reset Token or Email mismatch.');
            }elseif($userType === 'Staff'){
                return redirect('/staff')->with('sw_alert_session_error', 'Reset Token or Email mismatch.');
            }

    		return redirect('/')->with('sw_alert_session_error', 'Reset Token or Email mismatch.');
    	}        


    	//check expirity
        $expire_at = date('Y-m-d H:i', strtotime($resetData->created_at));
        $now = date('Y-m-d H:i', strtotime(Carbon::now()));

    	if ($expire_at < $now) {
            if ($userType === 'Admin') {
                return redirect()->route('admin.login')->with('error', 'Token Expired');
            }elseif($userType === 'KitchenStaff'){
                return redirect()->route('ks.login.form')->with('error', 'Token Expired');
            }elseif($userType === 'Staff'){
                return redirect('/staff')->with('sw_alert_session_error', 'Token Expired');
            }
    		return redirect('/')->with('sw_alert_session_error', 'Token Expired');
    	}

    	//update the password
        User::where(['email'=>decrypt($request->email)])->update([
            'password'=>Hash::make($request->password),
            'updated_at'=>Carbon::now()
        ]);

        $resetData->delete();
    	
        if ($userType === 'Admin') {
            return redirect()->route('admin.login')->with('success', 'Password reset success');
        }elseif($userType === 'KitchenStaff'){
            return redirect()->route('ks.login.form')->with('success', 'Password reset success');
        }elseif($userType === 'Staff'){
            return redirect('/staff')->with('sw_alert_session_success', 'Password reset success');
        }
        return redirect('/')->with('sw_alert_session_success', 'Password reset success');
    	
    }
}
