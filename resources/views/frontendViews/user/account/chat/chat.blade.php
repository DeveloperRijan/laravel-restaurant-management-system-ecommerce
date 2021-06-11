@if(is_numeric(\Request::get('ticket_id')))
 @include("frontendViews.user.account.chat.chat")
 @else
 @include("frontendViews.user.account.chat.archived")
@endif