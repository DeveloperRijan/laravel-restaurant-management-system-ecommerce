<?php
	$currentBalance = \App\Models\StaffCredit::where(["user_id"=>Auth::user()->id])->first();
?>


<div class="d-flex justify-content-between mb-2">
	<div>
		TopUp Credit
	</div>
	<div>
		<a href="{{route('staff.account.get')}}?data=credit&type=balance" class="btn btn-success btn-sm">Back</a>
	</div>
</div>


<div>
	<h6 class="text-center mt-3 mb-3" style="border-bottom: 1px solid #ddd; padding-bottom: 5px;">TopUp</h6>
</div>
<div class="container--wrapper" style="padding: 15px; padding-bottom: 150px;">
	@include("payment_gateways.paypal-credit-topup")

	<div class="text-center" style="margin-top: 80px;">
		<a onclick="return confirm('Are you sure?')" href="{{route('staff.test.credit.topup', Request::get('amount'))}}">Test TopUp</a>
	</div>
</div>
