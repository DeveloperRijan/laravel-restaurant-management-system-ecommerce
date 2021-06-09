@extends('backendViews.layouts.app')

@push("styles")
<style type="text/css">
  .size-options label{
    width: 100px;
    text-align: center;
    border: 1px solid #ddd;
    padding: 5px;
    border-radius: 3px;
    text-transform: uppercase;
    cursor: pointer;
  }
  .size-options label.size_active{
    background: forestgreen;
    color: #fff;
  }
</style>
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Staff<small class="ml-3 mr-3">|</small><small>Edit</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">Kitchen Staff</a>
          </li>
          <li class="breadcrumb-item active">Edit</li>
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
          <a class="nav-link active" href=""><i class="fa fa-edit mr-2"></i>Edit</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      
      <form id="productCreateForm" action="{{route('admin.edit.kitchen.staff.post')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="userID" value="{{encrypt($data->id)}}">
        <div class="form-group">
          <label>* Name</label>
          <input value="{{$data->name}}" type="text" name="name" placeholder="Name" required="1" class="form-control">
        </div>
        <div class="form-group">
          <label>* Email</label>
          <input value="{{$data->email}}" type="email" name="email" placeholder="Email" required="1" class="form-control">
        </div>
        <div class="form-group">
          <label>* Phone</label>
          <input value="{{$data->phone}}" type="tel" name="phone" placeholder="Phone" required="1" class="form-control">
        </div>
        
        <button class="btn btn-primary btn-sm" type="submit">Create</button>
      </form>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

@endsection

