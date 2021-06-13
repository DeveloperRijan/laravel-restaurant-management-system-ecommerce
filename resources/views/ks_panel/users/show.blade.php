@extends('ks_panel.layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">{{$user->type}}<small class="ml-3 mr-3">|</small><small>Details</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('ks.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">{{$user->type}}</a>
          </li>
          <li class="breadcrumb-item active">Details</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">
  <div class="clearfix"></div>
  @include("msg.msg")

  <?php
    $navigationTo = NULL;
    if ($user->type === "Customer") {
      $navigationTo = "customers";
    }elseif ($user->type === "Staff") {
      $navigationTo = "staffs";
    }
  ?>

  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
        <li class="nav-item">
          <a class="nav-link" href="{{route('ks.users.index')}}?type={{$navigationTo}}"><i class="fa fa-list mr-2"></i>{{$user->type}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="">Details</a>
        </li>
      </ul>
    </div>
    <div class="card-body">


      <div class="table-responsive">
        <table class="table dataTable" width="100%" style="width: 100%;">
          <tbody>
            <tr>
              <th><small>Status</small></th>
              @if($user->delete_at != null)
                <td>
                  <small><span class="badge badge-warning">Blocked</span></small>
                </td>
              @else
                <td>
                  <small>
                    <span class="badge badge-info">{{$user->status}}</span>
                  </small>
                </td>
              @endif
            </tr>
            <tr>
              <th><small>Name</small></th>
              <td><small>{{$user->name}}</small></td>
            </tr>
            <tr>
              <th><small>Email</small></th>
              <td><small>{{$user->email}}</small></td>
            </tr>

            @if($user->type === "Staff")
              <tr>
                <th><small>Company Name</small></th>
                <td><small>{{$user->company_name }}</small></td>
              </tr>
              <tr>
                <th><small>City</small></th>
                <td><small>{{$user->city }}</small></td>
              </tr>
              <tr>
                <th><small>State</small></th>
                <td><small>{{$user->state }}</small></td>
              </tr>
              <tr>
                <th><small>Post Code</small></th>
                <td><small>{{$user->post_code }}</small></td>
              </tr>

              <tr>
                <th><small>Designation</small></th>
                <td>
                  @if($user->get_designation)
                    <small>{{$user->get_designation->title}}</small>
                  @else
                    <small><span title="Designation Not Found">N/A</span></small>
                  @endif
                </td>
              </tr>         
            @endif
            
            <tr>
              <th><small>Registration Date</small></th>
              <td>
                <small>{{$user->created_at->format(env('GENERAL_DATE_FORMAT'))}}</small>
              </td>
            </tr>
          </tbody>
         
        </table>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
@endsection


