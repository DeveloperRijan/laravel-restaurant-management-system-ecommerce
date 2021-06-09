<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Models\App;

class AdminLoginController extends Controller
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
        return view('auth.admin_login');
    }

    //custom login
    public function custom_login(Request $request){
        $this->validate($request, [
            'email'=>'required|email',
            'password'=>'required|string|min:8'
        ]);

        if (!User::where(['type'=>"Admin",'email'=>$request->email])->exists()) {
            return redirect()->back()->with('error', "SORRY - Account not found");
        }

        if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password], $request->remember)) {
            return redirect()->intended(route('admin.dashboard'));
        }
        //if unsuccess to login then redirect
        return redirect()->back()->withInput($request->only('email', 'remember'))->with('error', "Invalid Login Credentials");

    }


    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
