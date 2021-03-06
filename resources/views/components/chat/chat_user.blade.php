@push('styles')
<link rel="stylesheet" type="text/css" href="{{$publicAssetsPathStart}}plugins/chat/jquery.mCustomScrollbar.min.css">
<link rel="stylesheet" type="text/css" href="{{$publicAssetsPathStart}}plugins/chat/chat.css">
@endpush

<div id="my__chat__box" class="container-fluid h-100">
   <div class="row justify-content-center h-100">
      <div class="col-md-4 col-xl-3 chat">
         <div class="card mb-sm-3 mb-md-0 contacts_card">
            <div class="card-header">
               <div class="input-group">
                  <input type="text" placeholder="Search..." name="" class="form-control search">
                  <div class="input-group-prepend">
                     <span class="input-group-text search_btn"><i class="fa fa-search"></i></span>
                  </div>
               </div>
            </div>
            <div class="card-body contacts_body">
               <ui class="contacts">
                  <li class="active">
                     <div class="d-flex bd-highlight">
                        <div class="img_cont">
                           <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
                           <span class="online_icon d-none"></span>
                        </div>
                        <div class="user_info">
                           <span>Khalid</span>
                           <p>Staff <small class="text-white">(2)</small></p>
                        </div>
                     </div>
                  </li>
               </ui>
            </div>
            <div class="card-footer"></div>
         </div>
      </div>
      <div class="col-md-8 col-xl-6 chat">
         <div class="card">
            <div class="card-header msg_head">
               <div class="d-flex bd-highlight">
                  <div class="img_cont">
                     <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
                     <span class="online_icon d-none"></span>
                  </div>
                  <div class="user_info">
                     <span>Support Team</span>
                  </div>
               </div>
            </div>
            <div class="card-body msg_card_body" id="my-messages-box">

               @include("components.chat.partials.user_messages")
               
            </div>

            @if($supportTicket->status === "Open")
            <div class="card-footer">
               <div class="input-group">
                  <div class="input-group-append d-none">
                     <span class="input-group-text attach_btn"><i class="fa fa-paperclip"></i></span>
                  </div>
                  <textarea name="composer" class="form-control type_msg" placeholder="Type your message..."></textarea>
                  <div class="input-group-append">
                     <span class="input-group-text send_btn"><i class="fa fa-location-arrow"></i></span>
                  </div>
               </div>
            </div>
            @endif
            <input type="hidden" name="ticket_id" value="{{$supportTicket->ticket_id}}">

         </div>
      </div>
   </div>
</div>


@push('scripts')
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/chat/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript">
   $(document).ready(function(){
   	$('#action_menu_btn').click(function(){
   		$('.action_menu').toggle();
   	});
   });
</script>
<script type="text/javascript">
   //chatbox always scrollbar bottom
   $(document).ready(function(){
   	$('#my__chat__box .msg_card_body').stop ().animate ({
   	  scrollTop: $('#my__chat__box .msg_card_body')[0].scrollHeight
   	});
   })
</script>

   <script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/chat/user_chat_scripts.js"></script>
   
   @if($supportTicket->status === "Open")
      <script type="text/javascript">
         //call every 5 seconds if ticket is open
         setInterval(function() {
          liveGetMessages()
        }, 5000);
      </script>
   @endif
@endpush