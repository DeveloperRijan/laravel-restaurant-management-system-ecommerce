@if(isset($chatContacts))
	@foreach($chatContacts as $key=>$ticket)
		@if(count($ticket->get_chats) > 0)
		<?php
			$activeTicketID = \Session::get('activeTicketID');
		?>
		<li class="single-contact @if($activeTicketID == $ticket->ticket_id) active @endif " 
			ticket_id="{{$ticket->ticket_id}}" 
			ticket_status="{{$ticket->status}}"
			ticket_subject="{{$ticket->subject}}"
			user_name="{{$ticket->get_user->name}}"
		>
		 <div class="d-flex bd-highlight">
		    <div class="user_info">
		       <span>
		       	<small>{{$ticket->get_user->name}}</small> 
		       </span>
		       <small style="font-size: 12px;display: block;">{{$ticket->get_user->type}}</small>
		       <p class="p-0 m-0">(Ticket ID : #{{$ticket->ticket_id}}) {{$ticket->status}}</p>
		    </div>
		 </div>
		</li>
		@endif
	@endforeach
@endif