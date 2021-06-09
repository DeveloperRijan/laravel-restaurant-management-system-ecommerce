@extends('backendViews.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Category<small class="ml-3 mr-3">|</small><small>Create</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a>
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
          <a class="nav-link" href="{{route('admin.categories.index')}}"><i class="fa fa-list mr-2"></i>Categories</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-plus mr-2"></i>Create Category</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      
      <form action="{{route('admin.categories.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="identity" value="main">
        <div class="form-group">
          <label>* Category/Menu Name</label>
          <input type="text" name="name" placeholder="Category/Menu Name"  class="form-control">
        </div>
        <div class="form-group">
          <label>* Type</label>
          <select class="form-control" name="type">
            <option value="Main">MainSite</option>
            <option value="Staff">StaffSite</option>
          </select>
        </div>
        <button class="btn btn-primary btn-sm" type="submit">Save</button>
      </form>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

@endsection
