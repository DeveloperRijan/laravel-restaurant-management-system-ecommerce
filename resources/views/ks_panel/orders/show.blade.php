@extends('backendViews.layouts.app')

@push("styles")
<style type="text/css">
  textarea {
    resize: none;
  }
</style>
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Order Details<small class="ml-3 mr-3">|</small><small>Orders Management</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">Order Details</a>
          </li>
          <li class="breadcrumb-item active">Order</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">
  <div class="clearfix"></div>
  @include("msg.msg")

  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between">
        <div>
          <a href="{{route('admin.orders.index')}}" class="btn btn-secondary btn-sm mr-1">Back to List</a>
        </div>
        <div>
          @if($order->status === "Pending")
          <a href="{{route('admin.order.actions', [encrypt($order->id), encrypt('Cancelled')])}}" onclick="return confirm('Are you sure to Cancel?')" class="btn btn-warning btn-sm mr-1">Cancel</a>
          <a href="{{route('admin.order.actions', [encrypt($order->id), encrypt('Accepted')])}}" onclick="return confirm('Are you sure to Accept?')" class="btn btn-primary btn-sm mr-1">Accept</a>
          <a href="{{route('admin.order.actions', [encrypt($order->id), encrypt('SoftDelete')])}}" onclick="return confirm('Are you sure to Delete?')" class="btn btn-danger btn-sm">Delete</a>
          @endif
          
          @if($order->status === "Accepted" || $order->status === "Cancelled")
            @if($order->status === "Accepted")
            <a href="{{route('admin.order.actions', [encrypt($order->id), encrypt('Completed')])}}" onclick="return confirm('Are you sure to Complete?')" class="btn btn-success btn-sm mr-1">Complete</a>
            @endif
            <a href="{{route('admin.order.actions', [encrypt($order->id), encrypt('SoftDelete')])}}" onclick="return confirm('Are you sure to Delete?')" class="btn btn-danger btn-sm">Delete</a>
          @endif
        </div>
      </div>
    </div>

    <div class="card-body">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Order Data</a>
        </li>
        @if($order->get_payment)
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">Payment Data</a>
        </li>
        @endif
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Shipping Address</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Customer</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
          @include("backendViews.orders.partials.order_data")
        </div>

        @if($order->get_payment)
        <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
          @include("backendViews.orders.partials.payment_data")
        </div>
        @endif

        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          @include("backendViews.orders.partials.shipping_address")
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
          @include("backendViews.orders.partials.customer")
        </div>
      </div>

      <div class="clearfix"></div>
    </div>
    
  </div>
</div>
@endsection


