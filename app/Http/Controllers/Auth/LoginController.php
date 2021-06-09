<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    //show login form
    public function show_login_from(){
        //return view('auth.login', compact('sliders', 'sectionData', 'appData'));
        return redirect()->route('root_page');
    }

    //custom login
    public function custom_login(Request $request){
        $validation = Validator::make($request->all(), [
            'email'=>'required|email',
            'password'=>'required|string|min:8'
        ]);

        if ($validation->fails()) {
            return response()->json([
                "msg"=>$validation->errors()->first()
            ], 422);
        }

        if (!User::where(['type'=>"Customer",'email'=>$request->email])->exists()) {
            return response()->json([
                "msg"=>"Account Not Found"
            ], 422);
        }

        if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password], $request->remember)) {
            //return redirect()->intended(route('user.dashboard'));
            return response()->json([
                'success'=>true, 
                'msg'=>"Login success",
                'data'=>['html_content'=>false]
            ], 200);
        }
        //if unsuccess to login then redirect
        return response()->json([
            "msg"=>"Invalid Login Credentials"
        ], 422);

    }


    public function logout(){
        Auth::logout();
        return redirect()->route('root_page');
    }


    //staff login
    public function kitchen_staff_login_form(Request $request){
        return view("auth.ks_staff_login");   
    }

    public function kitchen_staff_login(Request $request){
        $validation = Validator::make($request->all(), [
            'email'=>'required|email',
            'password'=>'required|string|min:8'
        ]);

        if ($validation->fails()) {
            return redirect()->back()->with("error", $validation->errors()->first());
        }

        if (!User::where(['type'=>"Kitchen Staff",'email'=>$request->email])->exists()) {
            return redirect()->back()->with("error", "No Account Found | You may register.");
        }

        if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password], $request->remember)) {
            return redirect()->route("ks.dashboard");
        }
        
        //if unsuccess to login then redirect
        return redirect()->back()->with("error", "Invalid Login Credentials");
    }


    public function staff_login(Request $request){
        $validation = Validator::make($request->all(), [
            'email'=>'required|email',
            'password'=>'required|string|min:8'
        ]);

        if ($validation->fails()) {
            //return redirect()->back()->with("error", $validation->errors()->first());
            return response()->json(["msg"=>$validation->errors()->first()], 422);
        }

        $staffAccount = User::where(['type'=>"Staff",'email'=>$request->email])->first();
        if (!$staffAccount) {
            //return redirect()->back()->with("error", "No Account Found | You may register.");
            return response()->json(["msg"=>"No Account Found | You may register."], 422);
        }

        //check its pending or active
        if ($staffAccount->status === "Pending") {
            return response()->json(["msg"=>"Your account is not activate yet!"], 422);   
        }

        if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password], $request->remember)) {
            //return redirect()->route("staff.account.get");
            return response()->json([
                'success'=>true, 
                'msg'=>"Login Success",
                'data'=>['html_content'=>false]
            ], 200);
        }
        
        //if unsuccess to login then redirect
        //return redirect()->back()->with("error", "Invalid Login Credentials");
        return response()->json(["msg"=>"Invalid Login Credentials"], 422);
    }
}
