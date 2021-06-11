@if(is_numeric(\Request::get('ticket_id')))
	@if($supportTicket)

	@push("styles")
		<link rel="stylesheet" href="{{$publicAssetsPathStart}}frontend/css/bootstrap4.6.0.min.css">
		<style type="text/css">
			
			#my__chat__box > div.h-100{
				justify-content:flex-start !important;
			}

			/*make the chatbot left side bar with auto for frontend users*/
		    #my__chat__box .col-xl-3{
		      display: none;
		    }

		    #my__chat__box .col-xl-6{
		        flex: 0 0 100%;
    			max-width: 100%;
		    }
		    .chat-block-wrapper{
		    	padding: 10px;
			    border: 1px solid #ddd;
			    border-radius: 5px;
		    }
		</style>
	@endpush

		<div class="header-chat-block mb-3">
			<p><b>Live Support</b></p>
		</div>
 		<div class="chat-block-wrapper">
 			<div class="row"> 
	 			<div class="col-lg-4 col-md-3 col-sm-12">
	 				<p class="m-1"><b>Subject </b> <br> <small>{{$supportTicket->subject}}</small></p>
	 				<p class="m-1"><b>Ticket ID </b> <br> <small>#{{$supportTicket->ticket_id}}</small></p>
	 				<p class="m-1"><b>Status </b> <br> <small>{{$supportTicket->status}}</small></p>
	 				<p class="m-1"><b>Opened </b> <br> <small>{{date(env('CHAT_DATE_FORMAT'), strtotime($supportTicket->created_at))}}</small></p>

	 				@if($supportTicket->status === "Closed")
	 					<p class="m-1"><b>Closed </b> <br> <small>{{date(env('CHAT_DATE_FORMAT'), strtotime($supportTicket->updated_at))}}</small></p>
	 					
 						<?php
 							$ticketClosedBy = \App\Models\User::withTrashed()->where('id', $supportTicket->closed_by)->first();
 						?>
 						@if($ticketClosedBy)
	 						@if($ticketClosedBy->id == \Auth::user()->id)
		 						<p class="m-1"><b>Closed By <small>(You)</small></b></p>
	 						@else
	 							<p class="m-1"><b>Closed By <small>({{$ticketClosedBy->type}})</small></b> <br> 
			 						<small>{{$ticketClosedBy->name}}</small>
			 					</p>
	 						@endif
	 					@endif
	 				@endif


	 				@if($supportTicket->status === "Open")
	 				<p class="mt-4">
	 					<a onclick="return confirm('Are you sure to close this Ticket?')" href="{{route('customer.supportTicketsActions', [encrypt($supportTicket->id), encrypt('Close')])}}" 
	 						style="text-decoration: none; color: #212121; background: #ddd; display: block; padding: 5px; border-radius: 3px; text-align: center;"><i class="fa fa-times"></i> Close Ticket</a>
	 				</p>
	 				@else
	 				<p class="mt-4">
	 					<a style="text-decoration: none; color: #212121; background: #ddd; display: block; padding: 5px; border-radius: 3px; text-align: center;"><i class="fa fa-check"></i> Ticket Closed</a>
	 				</p>
	 				@endif
	 				<br><br>
	 			</div>
	 			<div class="col-lg-8 col-md-9 col-sm-12">
	 				@include("components.chat.chat_user")
	 			</div>
	 		</div>
 		</div>
 	@else
 		<div style="min-height: 300px">
 			<p class="text-white text-center bg-danger p-4"><i class="fas fa-warning"></i> Invalid Support Ticket ID</p>
 		</div>
 	@endif
@else
	@include("frontendViews.user.account.chat.archived")
@endif