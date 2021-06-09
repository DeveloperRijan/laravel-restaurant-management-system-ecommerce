<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Designation;
use Carbon\Carbon;
use Auth;
use App\Mail\SendAccountActivationMail;
use Illuminate\Support\Facades\Mail;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->status === "blocked") {
            $query = $query->onlyTrashed();
        }

        if ($request->type === "customers") {
            $query = $query->where('type', "Customer")->with("get_orders");
        }elseif ($request->type === "staffs") {
            $query = $query->where('type', "Staff");
        }elseif ($request->type === "kitchen_staffs") {
            $query = $query->where('type', "Kitchen Staff");
        }else{
            return abort(404);
        }

        $data = $query->orderBy("created_at", "DESC")->get();
        
        $view = "backendViews.users.index";
        if (Auth::user()->type === "Kitchen Staff") {
            $view = "ks_panel.users.index";
        }
        return view($view, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::withTrashed()->where("id", '=', decrypt($id))->where('type', '!=', "Admin")->with('get_designation')->first();
        if (!$user) {
            return abort(404, "User Not Found");
        }
        return view("backendViews.users.show", compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //edit staff user only
        $user = User::withTrashed()->where("id", '=', decrypt($id))->where('type', '=', "Staff")->with('get_designation')->first();
        if (!$user) {
            return abort(404, "User Not Found");
        }
        return view("backendViews.users.edit_staff", compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //update staff user only
        $validation = Validator::make($request->all(), [
            'name'=>'required|string|max:60',
            'email'=>'required|string|email|max:99|unique:users,email,'.decrypt($id),
            'phone'=>'required|numeric|digits:'.\Config::get('constants.PHONE_NUM_LENGTH'),
            'code'=>'required|string|max:99|unique:users,code,'.decrypt($id),
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
            "id"=>decrypt($id),
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function actions($userID, $actionType){
        $user = User::withTrashed()->where('id', decrypt($userID))->first();
        if (!$user) {
            return abort(404);
        }

        if (decrypt($actionType) === "SoftDelete") {
            $user->delete();
            return redirect()->back()->with("success", "User Blocked");
        }

        if (decrypt($actionType) === "Unblock") {
            $user->restore();
            return redirect()->back()->with("success", "User Unblocked");
        }

        if (decrypt($actionType) === "Active") {
            $user->update(["status"=>"Active"]);
            
            Mail::to($user->email)->send(new SendAccountActivationMail($user));
            return redirect()->back()->with("success", "Account actived successfully");
        }
        
        return abort(403);
    }






    //kitchen staffs
    public function add_kitchen_staff_form(){
        return view("backendViews.kitchen_staff.create");
    }

    public function add_kitchen_staff_post(Request $request){
        $validation = Validator::make($request->all(), [
            'name'=>'required|string|max:60',
            'email'=>'required|string|email|max:99|unique:users',
            'phone'=>'required|numeric|digits:'.\Config::get('constants.PHONE_NUM_LENGTH'),
            'password'=>'required|string|min:8|max:16'
        ]);

        if ($validation->fails()) {
            return redirect()->back()->with("error", $validation->errors()->first());
        }

        $kitchenStaff = new User([
            'type'=>"Kitchen Staff",
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>Hash::make($request->password),
            'created_at'=>Carbon::now()
        ]);

        if ($kitchenStaff->save()) {
            return redirect()->back()->with("success", "Staff created successfully");
        }
        return redirect()->back()->with("error", "Internal server error | please try again later.");
    }


    public function edit_kitchen_staff_form($id){
        $data = User::where(["id"=>decrypt($id), "type"=>"Kitchen Staff"])->first();
        if (!$data) {
            return abort(404);
        }
        return view("backendViews.kitchen_staff.edit", compact('data'));
    }

    public function edit_kitchen_staff_post(Request $request){
        $validation = Validator::make($request->all(), [
            'userID'=>'required|string',
            'name'=>'required|string|max:60',
            'email'=>'required|string|email|max:99|unique:users,email,'.decrypt($request->userID),
            'phone'=>'required|numeric|digits:'.\Config::get('constants.PHONE_NUM_LENGTH')
        ]);

        if ($validation->fails()) {
            return redirect()->back()->with("error", $validation->errors()->first());
        }

        $currentData = User::where("id", decrypt($request->userID))->first();
        if (!$currentData) {
            return abort(404, "User Not Found");
        }
        $currentData->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'updated_at'=>Carbon::now()
        ]);

        return redirect()->back()->with("success", "Staff updated successfully");
    }




    // admin can update user password
    public function user_password_update(Request $request){
        $this->validate($request, [
            "user_id"=>"required|string",
            "password"=>"required|string|min:8|max:16"
        ]);

        $user = User::where('id', decrypt($request->user_id))->first();
        if (!$user) {
            return redirect()->back()->with("error", "User Not Found");
        }
        $user->update([
            "password"=>Hash::make($request->password)
        ]);
        return redirect()->back()->with("success", "Password Updated");
    }
}
