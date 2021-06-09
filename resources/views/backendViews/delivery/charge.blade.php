@extends('backendViews.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Delivery Charge<small class="ml-3 mr-3">|</small><small>Delivery</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item active">Delivery</li>
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
          <a class="nav-link active" href="{{route('admin.delivery-charge.index')}}?type=charge"><i class="fa fa-list mr-2"></i>Delivery Charge</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="" type="button" data-toggle="modal" data-target="#chargeConfigSetModal" ><i class="fa fa-gear mr-2"></i>Set</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      
      <div class="table-responsive">
        <table class="table">

          @if($data)
          <tr>
            <th>Charge Type</th>
            <td>General</td>
          </tr>

          <tr>
            <th>Charge Amount</th>
            <td>{{env('CURRENCY_SYMBOL').$data->charge_amount}}</td>
          </tr>

          <tr>
            <th>Last Modified</th>
            <td>
              @if($data->updated_at !== NULL)
                {{date(env("GENERAL_DATE_FORMAT"), strtotime($data->updated_at))}}
              @endif
            </td>
          </tr>

          @else
          <tr>
            <td colspan="2">No Data Found</td>
          </tr>
          @endif
        </table>
      </div>

      <div class="clearfix"></div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="chargeConfigSetModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Set Delivery Charge</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <form action="{{route('admin.delivery-charge.store')}}" method="POST">
          @csrf
          <input type="hidden" name="type" value="Charge">
          <div class="form-group">
            <label>* Delivery Charge Amount</label>
            <input type="number" name="charge_amount" step=".01" class="form-control" placeholder="Delivery Charge Amount"
            value="@if($data){{$data->charge_amount}}@endif">
          </div>
          <div class="form-group">
            <label>* Status</label>
            <select class="form-control" name="status">
              <option @if($data && $data->status === 'Active') selected  @endif value="Active">Active</option>
              <option @if($data && $data->status === 'Inactive') selected  @endif value="Inactive">Inactive</option>
            </select>
          </div>
          <div class="text-center form-group">
            <small>(General delivery charge that will apply on each order)</small><br>
            <small class="text-danger">Note : If Delivery charge is set and status=Active then it will be applied else delivery charge will display as Free.</small>
          </div>
          <button class="btn btn-primary btn-sm" type="submit">Save</button>
        </form>


      </div>
    </div>
  </div>
</div>

@endsection
