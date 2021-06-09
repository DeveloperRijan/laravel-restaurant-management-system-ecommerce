@extends('ks_panel.layouts.app')

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
          <li class="breadcrumb-item"><a href="{{ route('ks.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
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
          <a class="nav-link active" href="{{route('ks.profile.get')}}"><i class="fa fa-user mr-2"></i>Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('ks.password.update.form') }}"><i class="fa fa-lock mr-2"></i>Password</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      
      <form action="{{ route('ks.profile.update') }}" method="POST">
        @csrf
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" required="1">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control" required="1">
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input type="tel" name="phone" value="{{ Auth::user()->phone }}" class="form-control">
          </div>
          
          
          <div class="form-group">
            <label>Last Update</label>
            @if(Auth::user()->updated_at != '')
            <div>{{date(env('GENERAL_DATE_FORMAT'), strtotime(Auth::user()->updated_at))}}</div>
            @endif
          </div>
          <button type="submit" class="btn btn-primary btn-sm">UPDATE</button>
        </form>
      
      <div class="clearfix"></div>
    </div>
  </div>
</div>

@endsection
