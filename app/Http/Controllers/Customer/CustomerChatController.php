<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Auth;

class CustomerChatController extends Controller
{
 	public function open_ticket(Request $request){
 		$this->validate($request, [
 			"subject"=>"required|string|max:150"
 		]);

 		$ticket = new SupportTicket([
 			"user_id"=>Auth::user()->id,
 			"subject"=>$request->subject,
 			"created_at"=>Carbon::now()
 		]);

 		if (!$ticket->save()) {
 			return redirect()->back()->with("error", "Internal server error | please try again later.")
 		}

 		$supportTicketID = mt_rand(10, 999).$ticket->id;
 		SupportTicket::where("id", $ticket->id)->([
 			"ticket_id"=>$supportTicketID
 		]);

 		return redirect("/customer/account?data=support")->with("success", "Your ticket is opened now");
 	}   
}
