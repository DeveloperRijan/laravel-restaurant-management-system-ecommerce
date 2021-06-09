@extends('backendViews.layouts.app')

@push("styles")
<link rel="stylesheet" type="text/css" href="{{$publicAssetsPathStart}}plugins/filter_select/multi/bootstrap-multiselect.css">
<style type="text/css">
    .multiselect-native-select .btn-group{
        width: 100%
    }
    .multiselect-native-select .multiselect-container{
        width: 100%
    }
    /*filter*/
    .multiselect-native-select .multiselect-container .multiselect-filter div.input-group-prepend,
    .multiselect-native-select .multiselect-container .multiselect-filter button.multiselect-clear-filter
    {
        display: none;
    }

    /*options*/
    .multiselect-native-select .multiselect-container button.multiselect-option{
        width: 100%
    }
</style>
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Create Coupon<small class="ml-3 mr-3">|</small><small>Create</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">Coupons</a>
          </li>
          <li class="breadcrumb-item active">Create</li>
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
      <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
        <li class="nav-item">
          <a class="nav-link" href="{{route('admin.coupons.index')}}"><i class="fa fa-list mr-2"></i>Coupon</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-plus mr-2"></i>Create</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      
      <form action="{{route('admin.coupons.update', encrypt($data->id))}}" method="POST">
        @csrf
        @method("PUT")

        <div class="form-group">
          <label>* Coupon Code <small>(Should be Unique)</small></label>
          <input type="text" placeholder="Code" name="coupon_code" maxlength="99" class="form-control" value="{{$data->coupon_code}}">
        </div>


        <div class="form-group">
          <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="form-group">
                <label>* Discount <small>(%)</small></label>
                <input type="number" placeholder="Discount" name="coupon_discount" step="0.01" class="form-control" value="{{$data->coupon_discount}}">
                <small class="text-danger">Coupon Discount will be applied as percent value.</small>
              </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="form-group">
                <label>Number of Coupon <small>(Optional)</small></label>
                <input placeholder="Number of coupon" type="number" name="number_of_coupon" class="form-control" min="1" value="{{$data->number_of_coupon}}">
                <small class="text-danger">Note : Remeber if you keep it blank then coupon will be unlimited</small>
              </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="form-group">
                <label>* Expire Date</label>
                <input type="date" name="expire_date" class="form-control" value="{{$data->expire_date}}">
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label>* Status</label>
          <select class="form-control" name="status">
            <option @if($data->status === "Active") selected @endif value="Active">Active</option>
            <option @if($data->status === "Inactive") selected @endif value="Inactive">Inactive</option>
          </select>
        </div>
        
        <button class="btn btn-primary btn-sm" type="submit">Submit</button>
      </form>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

@endsection



@push("scripts")
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/filter_select/multi/bootstrap-multiselect.js"></script>
<!-- Initialize the plugin: -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#products_multi_select').multiselect({
            enableFiltering: true
        });
    });
</script>
@endpush
