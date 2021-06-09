@extends("frontendViews.layouts.master")

@push("styles")

@endpush

@section("content")

<div class="inner_popular container checkout-page" style="margin-bottom: 120px">
  <div class="row">
    <div class="col-lg-12 col-md-12">
      	@include("msg.msg")

		@if($status === 'success')
			orderID : {{\Session::get('order_id')}}
		@endif

  </div>
</div>

@endsection


@push("scripts")
@endpush