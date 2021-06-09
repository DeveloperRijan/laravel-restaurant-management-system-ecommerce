<?php
	//get credit balance used history
	$creditOrders = \App\Models\Order::where(["order_by"=>"Staff", "user_id"=>Auth::user()->id, "payment_type"=>"CREDIT BALANCE"])->orderBy("created_at", "DESC")->get();
	$currentBalance = \App\Models\StaffCredit::where(["user_id"=>Auth::user()->id])->first();
?>


<div class="d-flex justify-content-between mb-2">
	<div>
		@if($currentBalance)
		Credit Balance ({{env('CURRENCY_SYMBOL').$currentBalance->remaining_balance}})
		@else
		No Balance Found
		@endif
	</div>
	<div>
		<a data-bs-toggle="modal" data-bs-target="#topupAmountModal" href="{{route('staff.account.get')}}?data=credit&type=topup" class="btn btn-success btn-sm"><i class="fas fa-fill"></i> Credit TopUp</a>
	</div>
</div>


<div>
	<h6 class="text-center mt-3 mb-3" style="border-bottom: 1px solid #ddd; padding-bottom: 5px;">Credit Balance Used History</h6>
</div>
<div class="table-responsive">
	<table class="table text-center" id="datatable__tbl">
		<thead>
			<tr>
				<th>SN</th>
				<th>Order ID</th>
				<th>Item</th>
				<th>Payment Type</th>
				<th>Order Date</th>
			</tr>
		</thead>
		<tbody>

			@foreach($creditOrders as $key=>$order)
			<tr>
				<td>{{$key+1}}</td>
				<td>#{{$order->order_id}}</td>
				<td>
					<?php
						$orderData = json_decode($order->order_data, true);
						echo $orderData['checkout_summary']["products"][0]["product"]["title"];
					?>
				</td>
				<td>{{$order->payment_type}}</td>
				<td>
					{{date(env("GENERAL_DATE_FORMAT"), strtotime($order->created_at))}}
				</td>
			</tr>
			@endforeach
			
		</tbody>
	</table>
</div>


<!-- Modal -->
<div class="modal fade" id="topupAmountModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" style="max-width: 300px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Credit TopUp</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('staff.account.get')}}" method="GET">
        	<input type="hidden" name="data" value="credit">
        	<input type="hidden" name="type" value="topup">
        	<div class="form-group">
        		<label>Enter Amount</label>
        		<input type="number" name="amount" placeholder="Enter amount of topup" class="form-control">
        		<small>Note : Min : {{env('CURRENCY_SYMBOL').\Config::get("constants.CREDIT_TOPUP_AMOUNT.MIN")}} and Max : {{env('CURRENCY_SYMBOL').\Config::get("constants.CREDIT_TOPUP_AMOUNT.MAX")}}</small>
        	</div>
        	<br><br>
        	<button class="btn btn-success btn-sm btn-block" style="width: 100%">Go to Payment</button>
        </form>
      </div>
    </div>
  </div>
</div>
