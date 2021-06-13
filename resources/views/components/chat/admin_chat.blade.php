@push('styles')
<link rel="stylesheet" type="text/css" href="{{$publicAssetsPathStart}}plugins/chat/jquery.mCustomScrollbar.min.css">
<link rel="stylesheet" type="text/css" href="{{$publicAssetsPathStart}}plugins/chat/chat.css">
@endpush

<div id="my__chat__box" class="container-fluid h-100">
   <div class="row justify-content-center h-100">
      <div class="col-md-4 col-xl-3 chat">
         <div class="card mb-sm-3 mb-md-0 contacts_card">
            <div class="card-header d-none">
               <div class="input-group">
                  <input type="text" placeholder="Search..." name="" class="form-control search">
                  <div class="input-group-prepend">
                     <span class="input-group-text search_btn"><i class="fa fa-search"></i></span>
                  </div>
               </div>
            </div>
            <div class="card-body contacts_body">
               <ul class="contacts" id="chatContactList">
                  @include("components.chat.partials.chat_contacts")
               </ul>
            </div>
            <div class="card-footer"></div>
         </div>
      </div>
      <div class="col-md-8 col-xl-6 chat">
         <div class="card">
            <div class="card-header msg_head">
               <div class="d-flex bd-highlight">
                  <div class="user_info">
                     <span><small>Support to <small id="setActiveChatUserName"></small></small></span>
                     <span style="display: block;">
                        <small id="setActiveChatSubject" style="font-size: 12px"></small>
                     </span>
                  </div>
               </div>
               <span id="action_menu_btn"><i class="fa fa-ellipsis-v"></i></span>
               <div class="action_menu">
                  <ul>
                     <li><i class="fa fa-user"></i> <a href="{{route('')}}">Profile</a></li>
                     <li><i class="fa fa-times"></i> <a href="">Close Ticket</a></li>
                  </ul>
               </div>
            </div>

            <div class="card-body msg_card_body" id="my-messages-box">

               @include("components.chat.partials.admin_messages")
               
            </div>

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

   <script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/chat/ks_chat_scripts.js"></script>

   <script type="text/javascript">
      //call every 1.5 mins for contact list updates
      setInterval(function() {
       liveGetChatContacts()
     }, 90000);
   </script>

   <script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/sw_alert/sweetalert2@10.js"></script>
@endpush