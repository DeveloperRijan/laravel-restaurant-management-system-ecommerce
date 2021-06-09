<?php
	$addressData = json_decode($order->address_data, true);
?>

@if($addressData['note'])
<div>
	<h6 class="sub--heading">Address & Note</h6>
	<textarea readonly="1" readonly style="background:transparent;border: none;outline: none;width: 100%">NickName : {{$addressData['nick_name']}} - {{$addressData['address_line_1']}}, {{$addressData['address_line_2']}}, {{$addressData['city']}}, {{$addressData['post_code']}} || {{$addressData['note']}}</textarea>
</div>
@else
<h6 class="sub--heading">Address</h6>
<textarea readonly="1" readonly style="background:transparent;border: none;outline: none;width: 100%">NickName : {{$addressData['nick_name']}}, {{$addressData['address_line_1']}} - {{$addressData['address_line_2']}}, {{$addressData['city']}}, {{$addressData['post_code']}}</textarea>
@endif