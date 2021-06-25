<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Designation;
use App\Models\Company;
use App\Models\StaffInvitation;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use App\Mail\NewUserWelcome;
use Illuminate\Support\Facades\Mail;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    public function showRegistrationForm(){
        //$appData = App::first();
        return view("auth.register");
    }

    
    public function custom_register(Request $request){
        $validation = Validator::make($request->all(), [
            'name'=>'required|string|max:60',
            'email'=>'required|string|email|max:99|unique:users',
            'phone'=>'required|numeric|digits:'.\Config::get('constants.PHONE_NUM_LENGTH'),
            'password'=>'required|string|min:8|max:16|confirmed'
        ]);

        if ($validation->fails()) {
            return response()->json([
                "msg"=>$validation->errors()->first()
            ], 422);
        }


        $user = new User([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>Hash::make($request->password),
            'created_at'=>\Carbon\Carbon::now()
        ]);

        if ($user->save()) {
            //send welcome mail
            $to = $request->email;
            $userName = $request->name;
            Mail::to($to)->send(new NewUserWelcome($userName));

            return response()->json([
                'success'=>true, 
                'msg'=>"Registration Success",
                'data'=>['html_content'=>false]
            ], 200);
        }
        return response()->json([
            "msg"=>"Internal Server Error || Please try again later."
        ], 422);

    }





    public function staff_register_form(Request $request){
        // $invitationData = NULL;
        // if ($request->email != '' && $request->staff_id != '') {
        //     $query = StaffInvitation::query();
        //     $query->where("staff_id", decrypt($request->staff_id));
        //     $query->where("email", decrypt($request->email));
        //     $query->where("status", "Pending");
        //     $invitationData = $query->first();
        // }
        
        //return view("auth.staff_register", compact('invitationData'));
    }

    public function staff_register(Request $request){
        $validation = Validator::make($request->all(), [
            'name'=>'required|string|max:60',
            'email'=>'required|string|email|max:99|unique:users',
            'phone'=>'required|numeric|digits:'.\Config::get('constants.PHONE_NUM_LENGTH'),
            'address_line_one'=>'required|string|max:150',
            'address_line_two'=>'nullable|string|max:150',
            'city'=>'required|string|max:50',
            'state'=>'required|string|max:50',
            'company'=>'required|numeric',
            'designation'=>'required|numeric',
            'password'=>'required|string|min:8|max:16|confirmed'
        ]);

        if ($validation->fails()) {
            return response()->json(["msg"=>$validation->errors()->first()], 422);
            //return redirect()->back()->with('error', $validation->errors()->first());
        }

        //validate designation
        $designation = Designation::where('id', $request->designation)->first();
        if (!$designation) {
            return response()->json(["msg"=>"Invalid Designation Selected"], 422);
        }

        //validate company
        $company = Company::where('id', $request->company)->where('status', "Active")->first();
        if (!$company) {
            return response()->json(["msg"=>"Invalid Company Selected"], 422);
        }
        

        $user = new User([
            'type'=>"Staff",
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address_line_one'=>$request->address_line_one,
            'address_line_two'=>$request->address_line_two,
            'city'=>$request->city,
            'state'=>$request->state,
            'company_id'=>$company->id,
            'designation_id'=>$designation->id,
            'password'=>Hash::make($request->password),
            'status'=>"Pending",
            'created_at'=>\Carbon\Carbon::now()
        ]);

        if ($user->save()) {
            //send welcome mail
            $to = $request->email;
            $userName = $request->name;
            Mail::to($to)->send(new NewUserWelcome($userName));

            return response()->json([
                'success'=>true, 
                'msg'=>"Registration success. Your account is under review, please wait till active, we will notify you via email.",
                'data'=>['html_content'=>false]
            ], 200);
            //return redirect()->route("staff.login.form")->with('success', "Registration Success");
        }
        
        return response()->json(["msg"=>"Internal Server Error || Please try again later."], 422);
        //return redirect()->route()->with('error', "Internal Server Error || Please try again later.");
    }
}
