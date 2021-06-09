@extends('backendViews.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Create<small class="ml-3 mr-3">|</small><small>Designation</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.designations.index') }}">Designation</a>
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
          <a class="nav-link" href="{{route('admin.designations.index')}}"><i class="fa fa-list mr-2"></i>Designations</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-plus mr-2"></i>Create</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      
      <form action="{{route('admin.designations.store')}}" method="POST">
        @csrf

        <div class="form-group">
          <label>* Title <small>(Should be Unique)</small></label>
          <input type="text" placeholder="Title" name="title" maxlength="99" class="form-control" value="{{old('title')}}">
        </div>
        
        <button class="btn btn-primary btn-sm" type="submit">Submit</button>
      </form>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

@endsection
