<div>
	<div class="d-flex justify-content-end mb-3">
		<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#openTicketsModal">
		  Open Ticket
		</button>
	</div>
</div>

<div class="table-responsive">
	<table class="table text-center" id="datatable__tbl">
		<thead>
			<tr>
				<th>SN</th>
				<th>Ticket ID</th>
				<th title="Total Converstaions">Conversations</th>
				<th>Start Date</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>

			@foreach($tickets as $key=>$row)
			<tr>
				<td>{{$key+1}}</td>
				<td>#{{$row->ticket_id}}</td>
				<td>
						
				</td>
				<td>
					<span class="badge bg-secondary">{{$row->status}}</span>
				</td>
				<td>
					<span class="badge bg-secondary">{{$row->status}}</span>
				</td>
				<td>
					<a class="btn btn-primary btn-sm" href="{{ route('customer.account.get')}}?data=support&ticket_id={{$row->ticket_id}}"><i class="fas fa-eye"></i></a>
					
					@if($row->status === "Open")
						<a title="Open" class="btn btn-warning btn-sm" href="{{ route('customer.order.actions', [encrypt($row->ticket_id), encrypt('Close')]) }}"><i class="fas fa-times"></i></a>
					@endif

					@if($row->status === "Closed")
						<a title="Closed" class="btn btn-warning btn-sm" href="{{ route('customer.order.actions', [encrypt($row->ticket_id), encrypt('SoftDelete')]) }}"><i class="fas fa-times"></i></a>
					@endif
				</td>
			</tr>
			@endforeach
			
		</tbody>
	</table>
</div>



<!-- Modal -->
<div class="modal fade" id="openTicketsModal" tabindex="-1" aria-labelledby="openTicketsModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 500px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="openTicketsModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('customer.support.openTicket')}}" method="POST">
        	@csrf
        	<div class="form-group">
        		<label>* Subject</label>
        		<input type="text" name="subject" placeholder="Subject (150 characters max)" class="form-control" required="1" maxlength="150">
        	</div>
        	<div class="form-group">
        		<button onclick="return confirm('Are you sure?')" class="btn btn-success btn-sm" type="submit">Open Ticket & Start Chat</button>
        	</div>
        </form>
      </div>
    </div>
  </div>
</div>