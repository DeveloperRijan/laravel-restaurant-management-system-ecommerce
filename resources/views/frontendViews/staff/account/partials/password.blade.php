<div class="d-flex justify-content-between mb-2">
	<div>
		<h5>My Profile</h5>
	</div>
	<div>
		<a href="{{route('staff.account.get')}}?data=password" class="btn btn-secondary btn-sm">Update Password</a>
	</div>
</div>
<div class="table-responsive">

	<form action="{{route('staff.password.update')}}" method="POST">
		@csrf
		<table class="table">
			<tbody>
				<tr>
					<th>Current Password</th>
					<td>:</td>
					<td>
						<input type="password" name="current_password" class="form-control" required="1" placeholder="Current password">
					</td>
				</tr>
				<tr>
					<th>New Password</th>
					<td>:</td>
					<td>
						<input type="password" name="password" class="form-control" required="1" placeholder="New Password">
					</td>
				</tr>
				<tr>
					<th>Confirm Password</th>
					<td>:</td>
					<td>
						<input type="password" name="password_confirmation" class="form-control" required="1" placeholder="Password Confirmation">
					</td>
				</tr>

				<tr>
					<td colspan="3">
						<button class="btn btn-primary btn-sm" type="submit">Update</button>
					</td>
				</tr>

			</tbody>
		</table>
	</form>
</div>
