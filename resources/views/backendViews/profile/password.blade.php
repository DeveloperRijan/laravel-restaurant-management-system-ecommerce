@extends('backendViews.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">My Profile<small class="ml-3 mr-3">|</small><small>Profile</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item active">Password</li>
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
          <a class="nav-link" href="{{route('admin.profile.get')}}"><i class="fa fa-user mr-2"></i>Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('admin.password.update.form') }}"><i class="fa fa-lock mr-2"></i>Password</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      
          <form action="{{route('admin.password.update')}}" method="POST">
            @csrf
            <div class="form-group">
              <label>Current Password</label>
              <input type="password" name="current_password" placeholder="Enter current password" required="1" class="form-control">
            </div>
            <div class="form-group">
              <label>New Password</label>
              <input type="password" name="password" placeholder="Enter new password" required="1" class="form-control">
            </div>
            <div class="form-group">
              <label>Confirm Password</label>
              <input type="password" name="password_confirmation" placeholder="Enter confirm password" required="1" class="form-control">
            </div>
            <button type="sbumit" class="btn btn-primary btn-sm">UPDATE</button>
          </form>
      
      <div class="clearfix"></div>
    </div>
  </div>
</div>

@endsection
