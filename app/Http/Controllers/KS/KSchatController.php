<?php

namespace App\Http\Controllers\KS;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Chat;
use Carbon\Carbon;
use Auth;

class KSchatController extends Controller
{
    public function chat_page(){
    	//if has any session id then forget initally
    	\Session::forget('activeTicketID');

    	//return the view
    	return view("ks_panel.chat.chat");
    }

    public function sendMsg(Request $request){
 		//validate data
 		$validation = Validator::make($request->all(), [
            'ticket_id'=>'required|numeric',
            'msg'=>'required|string|max:'.\Config::get('constants.MAX_MSG_TXT')
        ]);

        if ($validation->fails()) {
            return response()->json([
                "msg"=>$validation->errors()->first()
            ], 422);
        }

        //validate ticket ID
        $ticket = SupportTicket::where(["ticket_id"=>$request->ticket_id])->first();
        if (!$ticket) {
        	return response()->json([
                "msg"=>"Invalid Support Ticket ID"
            ], 422);
        }

        if ($ticket->status !== "Open") {
        	return response()->json([
                "msg"=>"The ticket already ".$ticket->status
            ], 422);
        }

 		$message = new Chat([
 			//"sender_id"=>$ticket->user_id,
 			"ticket_id"=>$request->ticket_id,
 			"msg"=>$request->msg,
 			"responder_id"=>Auth::user()->id,
 			"created_at"=>Carbon::now()
 		]);


 		if ($message->save()) {
 			//get messages
 			$messages = Chat::where([
 				//"sender_id"=>$ticket->user_id,
 				"ticket_id"=>$request->ticket_id
 			])
 			->orderBy("created_at", "ASC")
 			->get();

 			return view("components.chat.partials.admin_messages", compact('messages'))->render();
 		}

 		return response()->json([
            "msg"=>"Internal server error | please try again later"
        ], 422);
 	}



 	public function getMessages(Request $request){
 		///validate ticket ID
        $ticket = SupportTicket::where(["ticket_id"=>$request->ticket_id])->first();
        if (!$ticket) {
        	return response()->json([
                "msg"=>"Invalid Support Ticket ID"
            ], 422);
        }

 		$messages = Chat::where([
 			"ticket_id"=>$request->ticket_id
 		])
 		->orderBy("created_at", "ASC")
 		->get();
 		if (\Session::get('activeTicketID') != $request->ticket_id) {
 			\Session::forget('activeTicketID');
 			\Session::put('activeTicketID', $request->ticket_id);
 		}
 		return view("components.chat.partials.admin_messages", compact('messages'))->render();
 	}



    public function ticket_actions($id, $type){
        $data = SupportTicket::where('id', decrypt($id))
                ->where("user_id", Auth::user()->id)
                ->first();

        if (!$data) {
            return abort(404);
        }

        if (decrypt($type) === "Close") {
            $data->update([
                "status"=>"Closed",
                "closed_by"=>Auth::user()->id
            ]);
            return redirect()->back()->with("success", "Ticket Closed");
        }

        if (decrypt($type) === "SoftDelete") {
            $data->delete();
            return redirect()->back()->with("success", "Ticket Deleted");
        }

        return abort(403);
        
    }


    public function getChatContacts(){
    	$chatContacts = SupportTicket::where("status", "Open")
    						->with(["get_chats", "get_user"])->orderBy("created_at", "DESC")
    						->get();
    	return view("components.chat.partials.chat_contacts", compact('chatContacts'))->render();
    }
}
