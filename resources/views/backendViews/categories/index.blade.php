@extends('backendViews.layouts.app')

@push("styles")
<link rel="stylesheet" href="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net-bs4/css/dataTables.bootstrap4.css" >
<style type="text/css">
  select.sort-by{
    width: 20%;
    border: 1px solid #ddd;
    padding: 5px;
    border-radius: 5px;
    margin-bottom: 10px;
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
        <h1 class="m-0 text-dark">Categories<small class="ml-3 mr-3">|</small><small>Management</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">Categories</a>
          </li>
          <li class="breadcrumb-item active">Categories</li>
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
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>Categories</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('admin.categories.create')}}"><i class="fa fa-plus mr-2"></i>Create Category/Menu</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="d-flex justify-content-end">
        <select class="sort-by" onchange="sortCategory(this.value)">
          <option value="">Sort By</option>
          <option @if(\Request::get('sort_by') === 'Main') selected="1" @endif value="Main">Main</option>
          <option @if(\Request::get('sort_by') === 'Staff') selected="1" @endif value="Staff">Staff</option>
        </select>
      </div>
      <div class="table-responsive">
        <table id="datatable__tbl" class="table dataTable" width="100%" style="width: 100%;">
         <thead>
            <tr role="row">
               <th>SN</th>
               <th>Name</th>
               <th>Type</th>
               <th>Updated At</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
          @foreach($data as $key=>$category)
            <tr role="row">
               <td>{{ $key+1}}</td>
               <td>{{$category->name}}</td>
               <td>{{$category->type}}</td>
               <td>
                  <small>
                    @if($category->updated_at != '')
                      {{$category->updated_at->format(env('GENERAL_DATE_FORMAT'))}}
                    @endif
                  </small>
               </td>
               <td>
                  <div class="btn-group btn-group-sm">
                     <a href="{{route('admin.categories.edit', encrypt($category->id))}}" class="btn btn-link">
                     <i class="fa fa-edit"></i>
                     </a>
                     <a onclick="return confirm('Are you sure to DELETE?')" href="{{route('admin.delete.category', encrypt($category->id))}}" class="btn btn-link">
                      <i class="fa fa-trash"></i>
                     </a>
                  </div>
               </td>
            </tr>
          @endforeach
           
         </tbody>
        </table>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
@endsection


@push("scripts")
<!-- datatable scripts -->
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/config_js/datatable_config.js"></script>

<script type="text/javascript">
  function sortCategory(value){
    window.location.href = "{{url()->current()}}?sort_by="+value
  }
</script>
@endpush

