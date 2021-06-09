@extends('backendViews.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Categories Management<small class="ml-3 mr-3">|</small><small>Delete</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a>
          </li>
          <li class="breadcrumb-item active">Delete</li>
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
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-trash mr-2"></i>Delete Category</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="text-info">
        <p style="font-size: 14px; text-align: center; padding: 15px; border: 1px dashed red;">The category <b>{{$data->name}}</b> have some products, So in order to complete your delete operation you have to move products to another category. So please select new category where current products of selected category (for delete) will be moved and selected category will be delete.</p>
      </div>
      <form action="{{route('admin.manage_and_delete_cat')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="current_category" value="{{encrypt($data->id)}}">
        <div class="form-group">
          <label>* Move current products to Category</label>
          <select class="form-control" name="move_products_to">
            <option value="">Select</option>
            @foreach($categories as $key=>$cat)
              <option value="{{encrypt($cat->id)}}">{{$cat->name}}</option>
            @endforeach
          </select>
        </div>
        
        <button class="btn btn-primary btn-sm" type="submit">Move and Delete</button>
      </form>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

@endsection
