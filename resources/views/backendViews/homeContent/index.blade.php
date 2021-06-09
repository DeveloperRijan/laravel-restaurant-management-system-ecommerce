@extends('backendViews.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Home Content<small class="ml-3 mr-3">|</small><small>Create</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          </li>
          <li class="breadcrumb-item active">Home Content</li>
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
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>Content Layouts</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      
      <form action="{{route('admin.home-content.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <table class="table">
          <thead>
            <tr>
              <th>Position</th>
              <th>* Category/Menu</th>
              <th title="How data/items will be taken from database for selected category/menu.">* Order By</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th>
                1 <input type="hidden" name="positions[0]" value="1">
              </th>
              <td>
                <select class="form-control" name="category[0]">
                  <option value="">Select</option>
                    @foreach($categories as $category)
                    <option @if($dataPos1 && $dataPos1->category_id == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
              </td>
              <td>
                <select class="form-control" name="order_by[0]">
                  <option value="">Select</option>
                  <option @if($dataPos1 && $dataPos1->order_by == 'Latest') selected @endif value="Latest">Latest</option>
                  <option @if($dataPos1 && $dataPos1->order_by == 'Oldest') selected @endif value="Oldest">Oldest</option>
                  <option @if($dataPos1 && $dataPos1->order_by == 'Random') selected @endif value="Random">Random</option>
                </select>
              </td>
            </tr>

            <tr>
              <th>
                2 <input type="hidden" name="positions[1]" value="2">
              </th>
              <td>
                <select class="form-control" name="category[1]">
                  <option value="">Select</option>
                  @foreach($categories as $category)
                  <option @if($dataPos2 && $dataPos2->category_id == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                  @endforeach
                </select>
              </td>
              <td>
                <select class="form-control" name="order_by[1]">
                  <option value="">Select</option>
                  <option @if($dataPos2 && $dataPos2->order_by == 'Latest') selected @endif value="Latest">Latest</option>
                  <option @if($dataPos2 && $dataPos2->order_by == 'Oldest') selected @endif value="Oldest">Oldest</option>
                  <option @if($dataPos2 && $dataPos2->order_by == 'Random') selected @endif value="Random">Random</option>
                </select>
              </td>
            </tr>

            <tr>
              <th>
                3 <input type="hidden" name="positions[2]" value="3">
              </th>
              <td>
                <select class="form-control" name="category[2]">
                  <option value="">Select</option>
                  @foreach($categories as $category)
                  <option @if($dataPos3 && $dataPos3->category_id == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                  @endforeach
                </select>
              </td>
              <td>
                <select class="form-control" name="order_by[2]">
                  <option value="">Select</option>
                  <option @if($dataPos3 && $dataPos3->order_by == 'Latest') selected @endif value="Latest">Latest</option>
                  <option @if($dataPos3 && $dataPos3->order_by == 'Oldest') selected @endif value="Oldest">Oldest</option>
                  <option @if($dataPos3 && $dataPos3->order_by == 'Random') selected @endif value="Random">Random</option>
                </select>
              </td>
            </tr>
          </tbody>
        </table>
      

        

        <button class="btn btn-primary btn-sm" type="submit">Save</button>
      </form>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

@endsection
