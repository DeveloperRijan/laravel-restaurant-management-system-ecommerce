<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\StaffInvitationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\StaffInvitation;
use App\Models\StaffAllowedDeliveryOrder;
use Carbon\Carbon;

class AdminStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //send invitation
        $invitations = StaffInvitation::where("status", "Pending")->orderBy("created_at", "DESC")->get();
        return view("backendViews.staffs.invitation", compact('invitations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "name"=>"required|string|max:50",
            "email"=>"nullable|string|max:99|email|unique:staff_invitations",
            "designation"=>"nullable|string|max:60"
        ]);

        if ($request->email != '') {
            $this->validate($request, [
                "email"=>"required|string|max:99|email|unique:users",
            ]);
        }

        $staffInvitation = new StaffInvitation([
            "name"=>$request->name,
            "email"=>$request->email,
            "designation"=>$request->designation,
            "created_at"=>Carbon::now()
        ]);

        if ($staffInvitation->save()) {
            $staffID = $staffInvitation->id.mt_rand(99, 999);
            StaffInvitation::where('id', $staffInvitation->id)->update(["staff_id"=>$staffID]);
            if ($request->email != '') {
                //send email
                Mail::to($request->email)->send(new StaffInvitationMail($request->name, $request->email, $staffID));
                return redirect()->back()->with("invitation_success", [
                    "msg"=>"Process done, below is the staff ID (Code), please send this code to staff to register on system & system has sent invitation email too.",
                    "code"=>$staffID
                ]);
            }

            return redirect()->back()->with("invitation_success", [
                "msg"=>"Process done, below is the staff ID (Code), please send this code to staff to register on system.",
                "code"=>$staffID
            ]);
        }

        return redirect()->back()->with("error", "Internal server error | please try again later.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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


    //list company codes thats are allowed to make Delivery Order
    public function staff_delivey_type(){
        $allowedCodes = StaffAllowedDeliveryOrder::orderBy("created_at", "DESC")->get();

        return view("backendViews.staffs.allowed_delivery_order", compact('allowedCodes'));
    }

    public function staff_delivey_type_post(Request $request){
        $this->validate($request, [
            "code"=>"required|unique:staff_allowed_delivery_orders"
        ]);

        $code = new StaffAllowedDeliveryOrder([
            "code"=>$request->code,
            "created_at"=>Carbon::now()
        ]);

        if ($code->save()) {
            return redirect()->back()->with("success", "Code Saved");
        }
        return redirect()->back()->with("error", "Internal server error | Please try again later.");
    }

    public function staff_delivey_type_delete($id, $actionType){
        $data = StaffAllowedDeliveryOrder::where("id", decrypt($id))->first();
        if (!$data) {
            return abort(404, "Code Not Found");
        }
        $data->delete();
        return redirect()->back()->with("success", "Code Deleted");
    }
}
