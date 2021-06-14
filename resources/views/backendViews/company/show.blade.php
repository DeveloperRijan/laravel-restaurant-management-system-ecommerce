@extends('backendViews.layouts.app')

@push("styles")
<style type="text/css">
  input[type='time']{
    border: 1px solid #ddd;
    padding: 3px;
    border-radius: 3px;
    outline: none;
  }
</style>
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Company<small class="ml-3 mr-3">|</small><small>Management</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">Admin</a>
          </li>
          <li class="breadcrumb-item active">Profile</li>
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
          <a class="nav-link" href="{{route('admin.companies.index')}}?status=Active"><i class="fa fa-list mr-2"></i>Companies</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href=""><i class="fa fa-edit mr-2"></i>Profile</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="d-flex justify-content-end">
        @if($company->status === "Active")
        <a onclick="return confirm('Are you sure to Inactive?\n Once you inactive no new staff can singup with this company until you re-active!')" href="{{route('admin.companyActions', [encrypt($company->id), encrypt('Inactive')])}}" class="btn btn-warning btn-sm">Active</a>
        @else
        <a onclick="return confirm('Are you sure to Inactive?\n Once you inactive no new staff can singup with this company until you re-active!')" href="{{route('admin.companyActions', [encrypt($company->id), encrypt('Active')])}}" class="btn btn-success btn-sm">Active</a>
        @endif

        <a href="" class="btn btn-info btn-sm"></a>
      </div>

      <div class="table-responsive">
        <table class="table">
          <tr>
            <th width="30%"><small>Name</small></th>
            <td width="4%"><small>:</small></td>
            <td><small>{{$company->name}}</small></td>
          </tr>
          <tr>
            <th width="30%"><small>Code</small></th>
            <td width="4%"><small>:</small></td>
            <td><small>{{$company->code}}</small></td>
          </tr>
          <tr>
            <th width="30%"><small>Address line one</small></th>
            <td width="4%"><small>:</small></td>
            <td><small>{{$company->address_line_one}}</small></td>
          </tr>
          <tr>
            <th width="30%"><small>Address line two</small></th>
            <td width="4%"><small>:</small></td>
            <td><small>{{$company->address_line_two}}</small></td>
          </tr>
          <tr>
            <th width="30%"><small>City</small></th>
            <td width="4%"><small>:</small></td>
            <td><small>{{$company->city}}</small></td>
          </tr>
          <tr>
            <th width="30%"><small>State</small></th>
            <td width="4%"><small>:</small></td>
            <td><small>{{$company->state}}</small></td>
          </tr>
          <tr>
            <th width="30%"><small>Can Order Any Time</small></th>
            <td width="4%"><small>:</small></td>
            <td><small>{{$company->can_order_any_time}}</small></td>
          </tr>

          @if($company->can_order_any_time === "No")
          <tr>
            <th width="30%"><small>Company Allowcated Hours</small></th>
            <td width="4%"><small>:</small></td>
            <td>
              <small>
                <span style="display: block;">{{date('H:i A', strtotime($company->start_time))}} to {{date('H:i A', strtotime($company->end_time))}}</span>
                <span style="display: block;">{{$company->start_day}} to {{$company->end_day}}</span>
              </small>
            </td>
          </tr>
          @endif

          <tr>
            <th width="30%"><small>Discount</small></th>
            <td width="4%"><small>:</small></td>
            <td><small>{{$company->discount_percent}}%</small></td>
          </tr>
        </table>
      </div>


      <div class="clearfix"></div>
    </div>
  </div>
</div>



@endsection

