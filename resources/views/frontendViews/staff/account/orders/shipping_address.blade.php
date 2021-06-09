<?php
	$addressData = json_decode($order->address_data, true);
?>
<table class="table">
	<tr>
		<th width="25%">Nick Name</th>
		<td width="10%">:</td>
		<td>{{$addressData['nick_name']}}</td>
	</tr>
	<tr>
		<th width="25%">Mobile Number</th>
		<td width="10%">:</td>
		<td>{{$addressData['mobile_number']}}</td>
	</tr>
	<tr>
		<th width="25%">Address line 1</th>
		<td width="10%">:</td>
		<td><textarea readonly style="background:transparent;border: none;outline: none;width: 100%">{{$addressData['address_line_1']}}</textarea></td>
	</tr>

	<tr>
		<th width="25%">Address line 2</th>
		<td width="10%">:</td>
		<td><textarea readonly style="background:transparent;border: none;outline: none;width: 100%">{{$addressData['address_line_2']}}</textarea></td>
	</tr>
	<tr>
		<th width="25%">City</th>
		<td width="10%">:</td>
		<td>{{$addressData['city']}}</td>
	</tr>
	<tr>
		<th width="25%">Post Code</th>
		<td width="10%">:</td>
		<td>{{$addressData['post_code']}}</td>
	</tr>
	<tr>
		<th width="25%">Extra Note</th>
		<td width="10%">:</td>
		<td><textarea readonly style="background:transparent;border: none;outline: none;width: 100%">{{$addressData['note']}}</textarea></td>
	</tr>
</table>