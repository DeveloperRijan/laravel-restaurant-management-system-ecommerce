<div class="table-responsive">
	<table class="table text-center" id="datatable__tbl">
		<thead>
			<tr>
				<th>SN</th>
				<th>Order ID</th>
				<th>Items</th>
				<th>Payment Type</th>
				<th>Status</th>
				<th>Order Date</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>

			@foreach($orders as $key=>$order)
			<tr>
				<td>{{$key+1}}</td>
				<td>#{{$order->order_id}}</td>
				<td>
					<?php
						$orderData = json_decode($order->order_data, true);
						echo count($orderData['products']);
					?>
				</td>
				<td>{{$order->payment_type}}</td>
				<td>
					<span class="badge bg-secondary">{{$order->status}}</span>
				</td>
				<td>
					{{date(env("GENERAL_DATE_FORMAT"), strtotime($order->created_at))}}
				</td>
				<td>
					<a class="btn btn-primary btn-sm" href="{{ route('customer.account.get')}}?data=orders&id={{encrypt($order->id)}}"><i class="fas fa-eye"></i></a>
					
					@if($order->status === "Pending")
					<a title="Cancel Order" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure to CANCEL?')" href="{{ route('customer.order.actions', [encrypt($order->id), encrypt('Cancelled')]) }}"><i class="fas fa-times"></i></a>
					@endif

					@if($order->status === "Completed" || $order->status === "Cancelled")
					<a title="Delete this Order" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to DELETE?')" href="{{ route('customer.order.actions', [encrypt($order->id), encrypt('SoftDelete')]) }}"><i class="fas fa-times"></i></a>
					@endif
				</td>
			</tr>
			@endforeach
			
		</tbody>
	</table>
</div>