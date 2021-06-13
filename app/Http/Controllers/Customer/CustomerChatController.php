<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SupportTicket;
use App\Models\Chat;
use Carbon\Carbon;
use Auth;

class CustomerChatController extends Controller
{
 	public function open_ticket(Request $request){
 		$this->validate($request, [
 			"subject"=>"required|string|max:150"
 		]);

        //check their has any tickets is opened
        $currentOpenTicket = SupportTicket::where("user_id", Auth::user()->id)
                                    ->where('status', "Open")
                                    ->first();
        if ($currentOpenTicket) {
            return redirect()->back()->with("error", "You have already an open ticket, please close current open ticket to start new. Current Open Ticket ID : ".$currentOpenTicket->ticket_id);
        }

 		$ticket = new SupportTicket([
 			"user_id"=>Auth::user()->id,
 			"subject"=>$request->subject,
 			"created_at"=>Carbon::now()
 		]);

 		if (!$ticket->save()) {
 			return redirect()->back()->with("error", "Internal server error | please try again later.");
 		}

 		$supportTicketID = mt_rand(10, 999).$ticket->id;
 		SupportTicket::where("id", $ticket->id)->update([
 			"ticket_id"=>$supportTicketID
 		]);

 		return redirect("/customer/account?data=support&ticket_id=".$supportTicketID)->with("success", "Your ticket is opened");
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
        $ticket = SupportTicket::where(["user_id"=>Auth::user()->id, "ticket_id"=>$request->ticket_id])->first();
        if (!$ticket) {
        	return response()->json([
                "msg"=>"Invalid Support Ticket ID"
            ], 422);
        }

        if ($ticket->status !== "Open") {
        	return response()->json([
                "msg"=>"Invalid Support Ticket ID | The ticket already ".$ticket->status
            ], 422);
        }

 		$message = new Chat([
 			"sender_id"=>Auth::user()->id,
 			"ticket_id"=>$request->ticket_id,
 			"msg"=>$request->msg,
 			"created_at"=>Carbon::now()
 		]);


 		if ($message->save()) {
 			//get messages
 			$messages = Chat::where([
 				//"sender_id"=>Auth::user()->id,
 				"ticket_id"=>$request->ticket_id
 			])
 			->orderBy("created_at", "ASC")
 			->get();

 			return view("components.chat.partials.user_messages", compact('messages'))->render();
 		}

 		return response()->json([
            "msg"=>"Internal server error | please try again later"
        ], 422);
 	}



 	public function getMessages(Request $request){
 		///validate ticket ID
 		$authUserID = Auth::user()->id;

        $ticket = SupportTicket::where(["user_id"=>$authUserID, "ticket_id"=>$request->ticket_id])->first();
        if (!$ticket) {
        	return response()->json([
                "msg"=>"Invalid Support Ticket ID"
            ], 422);
        }

 		$messages = Chat::where([
 				//"sender_id"=>$authUserID,
 				"ticket_id"=>$request->ticket_id
 			])
 			->orderBy("created_at", "ASC")
 			->get();

 		return view("components.chat.partials.user_messages", compact('messages'))->render();
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
}
