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
	 				<p class="m-0"><b>Subject : </b> {{$supportTicket->subject}}</p>
	 				<p class="m-0"><b>Ticket ID : </b> #{{$supportTicket->ticket_id}}</p>
	 				<p class="m-0"><b>Status : </b> {{$supportTicket->status}}</p>
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