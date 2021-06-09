<table class="table">
	<tr>
		<th width="25%">Payment Method</th>
		<td width="10%">:</td>
		<td>{{$order->payment_method}}</td>
	</tr>
	<tr>
		<th width="25%">Paid Amount</th>
		<td width="10%">:</td>
		<td>{{env('CURRENCY_SYMBOL').$order->paid_amount}}</td>
	</tr>
	<tr>
		<th width="25%">Paypal Transaction ID</th>
		<td width="10%">:</td>
		<td>#{{$order->paypal_transaction_id}}</td>
	</tr>
	<tr>
		<th width="25%">Payer Name</th>
		<td width="10%">:</td>
		<td>{{$order->payer_name}}</td>
	</tr>

	<tr>
		<th width="25%">Payer Email</th>
		<td width="10%">:</td>
		<td>{{$order->payer_email}}</td>
	</tr>
	<tr>
		<th width="25%">Payment Status</th>
		<td width="10%">:</td>
		<td>{{$order->status}}</td>
	</tr>
</table>