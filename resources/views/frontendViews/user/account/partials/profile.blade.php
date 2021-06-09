<div class="d-flex justify-content-between mb-2">
	<div>
		<h5>My Profile</h5>
	</div>
	<div>
		<button class="btn btn-info btn-sm" id="profileEditBTN">Edit</button>
		<button class="btn btn-info btn-sm d-none" id="profileShowBTN">Profile</button>
		<a href="{{route('customer.account.get')}}?data=password" class="btn btn-secondary btn-sm">Update Password</a>
	</div>
</div>
<div class="table-responsive">
	<table class="table" id="profileViewMode">
		<tbody>
			<tr>
				<th>Name</th>
				<td>:</td>
				<td>{{Auth::user()->name}}</td>
			</tr>
			<tr>
				<th>Email</th>
				<td>:</td>
				<td>{{Auth::user()->email}}</td>
			</tr>
			<tr>
				<th>Phone</th>
				<td>:</td>
				<td>{{Auth::user()->phone}}</td>
			</tr>
			<tr>
				<th>Register Date</th>
				<td>:</td>
				<td>{{Auth::user()->created_at->format(env("GENERAL_DATE_FORMAT"))}}</td>
			</tr>

		</tbody>
	</table>

	<form action="{{route('customer.profile.update')}}" method="POST">
		@csrf
		<table class="table d-none" id="profileEditMode">
			<tbody>
				<tr>
					<th>Name</th>
					<td>:</td>
					<td>
						<input type="text" name="name" class="form-control" value="{{Auth::user()->name}}" required="1">
					</td>
				</tr>
				<tr>
					<th>Email</th>
					<td>:</td>
					<td>
						<input type="email" name="email" class="form-control" value="{{Auth::user()->email}}" required="1">
					</td>
				</tr>
				<tr>
					<th>Phone</th>
					<td>:</td>
					<td>
						<input type="tel" name="phone" class="form-control" value="{{Auth::user()->phone}}" required="1">
					</td>
				</tr>

				<tr>
					<td colspan="3">
						<button class="btn btn-primary btn-sm" type="submit">Save</button>
					</td>
				</tr>

			</tbody>
		</table>
	</form>
</div>



@push("scripts")
<script type="text/javascript">
	$("#profileEditBTN").on("click", function(){
		$(this).addClass("d-none")

		$("#profileViewMode").addClass("d-none")
		$("#profileEditMode").removeClass("d-none")
		$("#profileShowBTN").removeClass("d-none")
	})

	$("#profileShowBTN").on("click", function(){
		$(this).addClass("d-none")

		$("#profileViewMode").removeClass("d-none")
		$("#profileEditMode").addClass("d-none")
		$("#profileEditBTN").removeClass("d-none")
	})
</script>
@endpush