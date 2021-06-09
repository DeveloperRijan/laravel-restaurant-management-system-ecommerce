@extends('backendViews.layouts.app')

@push("styles")
<style type="text/css">
  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }
</style>
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Batch Coupon<small class="ml-3 mr-3">|</small><small>Setting</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item "><a href="{{ route('admin.products.index') }}">Batch Coupon</a>
          </li>
          <li class="breadcrumb-item active">Setting</li>
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
          <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>Coupons</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      
      <form action="{{route('admin.batch.coupon.setting.post')}}" method="POST">
        @csrf        
        <div class="form-group">
          <table class="table">
            <thead>
              <tr>
                <th>SN</th>
                <th>Type</th>
                <th>City</th>
                <th>Designation</th>
                <th>Batch Coupon %</th>
                <th class="d-none">20 Batch Coupon %</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>01</td>
                <td>
                  <span class="badge badge-success">Special</span>
                </td>
                <td>
                  <?php
                    $specialCities = \Config::get("constants.SEPECIAL_CITIES");
                    echo $specialCities[0];
                  ?>
                </td>
                <td>
                  <?php
                    $currentCity = NULL;
                    if ($specialCoupon) {
                      $currentCity = $specialCoupon->designation_id;
                    }
                  ?>
                  <select class="form-control" name="special_designation">
                    <option value="">Select</option>
                    @foreach($designations as $key=>$designation)
                      <option @if($currentCity == $designation->id) selected @endif value="{{$designation->id}}">{{$designation->title}}</option>
                    @endforeach
                  </select>
                </td>
                <td>
                  @if($specialCoupon)
                  <input value="{{$specialCoupon->batch_10}}" name="special_10_batch" type="number" step="00.01" class="form-control">
                  @else
                  <input name="special_10_batch" type="number" step="00.01" class="form-control">
                  @endif
                </td>
                <td class="d-none">
                  @if($specialCoupon)
                  <input value="{{$specialCoupon->batch_20}}" name="special_20_batch" type="number" step="00.01" class="form-control">
                  @else
                  <input name="special_20_batch" type="number" name="" step="00.01" class="form-control">
                  @endif
                </td>
              </tr>

              <tr>
                <td>02</td>
                <td>
                  <span class="badge badge-warning">General</span>
                </td>
                <td>All</td>
                <td>All</td>
                <td>
                  @if($generalCoupon)
                  <input value="{{$generalCoupon->batch_10}}" name="general_10_batch" type="number" step="00.01" class="form-control">
                  @else
                  <input name="general_10_batch" type="number" step="00.01" class="form-control">
                  @endif
                </td>
                <td class="d-none">
                  @if($generalCoupon)
                  <input value="{{$generalCoupon->batch_20}}" name="general_20_batch" type="number" step="00.01" class="form-control">
                  @else
                  <input name="general_20_batch" type="number" step="00.01" class="form-control">
                  @endif
                </td>
              </tr>
            </tbody>
          </table>  
        </div>   
        <button class="btn btn-primary btn-sm" type="submit">Save</button>
      </form>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

@endsection


@push("scripts")

@endpush
