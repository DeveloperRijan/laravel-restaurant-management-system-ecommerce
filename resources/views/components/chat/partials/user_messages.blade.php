@if(isset($messages) && count($messages) > 0)
   
   <?php
      $authUser = Auth::user();
   ?>

   @foreach($messages as $key=>$message)
      @if($authUser->id == $message->sender_id)
         <div class="d-flex justify-content-end mb-4">
            <div>
               <div class="msg_cotainer_send">
                  {!! nl2br(e($message->msg)) !!}
               </div>
               <span class="msg_time_send">8:55 AM, Today</span>
            </div>
            <div class="img_cont_msg">
               <small>Me</small>
            </div>
         </div>
      @else
         <div class="d-flex justify-content-start mb-4">
            <div class="img_cont_msg">
               <small>Team</small>
            </div>
            <div>
               <div class="msg_cotainer">
                  {!! nl2br(e($message->msg)) !!}
               </div>
               <span class="msg_time">8:40 AM, Today</span>
            </div>
         </div>
      @endif
   @endforeach


@else
   <p class="text-white">
      <small>Type something and hit the send button to start chat...</small>
   </p>
@endif