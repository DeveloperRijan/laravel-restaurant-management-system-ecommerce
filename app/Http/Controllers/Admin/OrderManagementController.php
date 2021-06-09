<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MSGSender;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\SMSSendLog;
use App\Models\User;
use App\Models\NotificationSetting;
use Carbon\Carbon;
use Auth;
use App\Mail\OrderProcessingNotificationMail;
use Illuminate\Support\Facades\Mail;

class OrderManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Order::query();
        $query->orderBy("created_at", "DESC");

        if ($request->type != '') {
            $query->where('status', $request->type);
        }

        $orders = $query->with("get_customer")->paginate(\Config::get("constants.ORDER.INIT_PAGINATE"));

        $view = "backendViews.orders.index";
        if (Auth::user()->type === "Kitchen Staff") {
            $view = "ks_panel.orders.index";
        }
        return view($view, compact('orders'));
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
        $order = Order::where('id', decrypt($id))->with(["get_customer", "get_payment"])->first();
        if (!$order) {
            return abort(404);
        }
        if (Auth::user()->type !== "Admin") {
            return abort(404);
        }
        return view("backendViews.orders.show", compact('order'));
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


    public function order_actions($orderID, $actionType){
        $data = Order::where('id', decrypt($orderID))->first();
        if (!$data) {
            return abort(404);
        }

        if (decrypt($actionType) === "SoftDelete") {
            $data->delete();
            return redirect()->route("admin.orders.index")->with("success", "Order Record Deleted");
        }

        $data->update([
            "status"=>decrypt($actionType),
            "updated_at"=>Carbon::now()
        ]);

        //process notifications
        return $this->processOrderNotifications($orderID, $actionType);

        //return redirect()->back()->with("success", "Order ".decrypt($actionType));

    }

    private function processOrderNotifications($orderID, $actionType){
        $actionType = decrypt($actionType);
        $orderData = Order::where('id', decrypt($orderID))->first();

        $notification = NotificationSetting::where("context", $actionType)->first();
        if (!$notification) {
            return redirect()->back()->with("success", "Order ".$actionType);
        }

        //then send notification
        $user = User::withTrashed()->where('id', $orderData->user_id)->first();
        
        //if mode email
        if ($notification->notification_mode === "Email") {
            Mail::to($user->email)->send(new OrderProcessingNotificationMail($user, $orderData));
            return redirect()->back()->with("success", "Order ".$actionType." and notification has been sent to email.");
        }

        //if mode phone
        if ($notification->notification_mode === "Phone") {
            $message = "Your order is now ".$orderData->status.". Order ID : #".$orderData->order_id;
            $response = MSGSender::send($user->phone, $message);
            
            //store sms sending log
            SMSSendLog::insert([
                "user_id"=>$user->id,
                "response"=>json_encode($response),
                "created_at"=>Carbon::now()
            ]);

            return redirect()->back()->with("success", "Order ".$actionType." and notification has been sent to phone.");
        }

        //if both then send mail and sms
        if ($notification->notification_mode === "Both") {
            Mail::to($user->email)->send(new OrderProcessingNotificationMail($user, $orderData));

            $message = "Your order is now ".$orderData->status.". Order ID : #".$orderData->order_id;
            $response = MSGSender::send($user->phone, $message);

            //store sms sending log
            SMSSendLog::insert([
                "user_id"=>$user->id,
                "response"=>json_encode($response),
                "created_at"=>Carbon::now()
            ]);

            return redirect()->back()->with("success", "Order ".$actionType." and notification has been sent to phone & email.");
        }

        return redirect()->back()->with("success", "Order ".$actionType);
    }




    public function custom_datatables_data(Request $request){
        $searchKey = $request->search_key;
        $sort_by = $request->sort_by;
        $sorting_order = $request->sorting_order;
        $status = $request->status;
        $row_per_page = $request->row_per_page;
        //$id = $request->id;
        
        //$from_date = $request->param_1;
        //$to_date = $request->param_2;


        if ($sort_by == "") {
            $sort_by = "id";
        }
        if ($sorting_order == "") {
            $sorting_order = "DESC";
        }

        $query = Order::query();


        $query->with('get_customer');

        if ($searchKey != '') {

            if(is_numeric($searchKey)){
                $query->where('order_id', 'LIKE', "%" .$searchKey. "%");

                $query->orWhereHas('get_customer', function($q) use ($searchKey){
                    $q->where('phone', 'LIKE', "%" .$searchKey. "%");
                });

            }else{
                $query->whereHas('get_customer', function($q) use ($searchKey){
                    $q->where('name', 'LIKE', "%" .$searchKey. "%");
                    $q->orWhere('email', 'LIKE', "%" .$searchKey. "%");
                    $q->orWhere('post_code', 'LIKE', "%" .$searchKey. "%");
                    $q->orWhere('code', 'LIKE', "%" .$searchKey. "%");
                });
            }
            
        }
                

        if ($status !== "index") {
            $query->where('status', $status);
        }
        $orders = $query->orderBy($sort_by, $sorting_order)->paginate($row_per_page);

        
        $view = "backendViews.orders.partials.new-list";
        if (Auth::user()->type === "Kitchen Staff") {
            $view = "ks_panel.orders.partials.new-list";
        }
        return view($view, compact('orders'))->render();
    }
}
