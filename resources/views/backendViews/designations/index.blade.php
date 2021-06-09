@extends('backendViews.layouts.app')

<link rel="stylesheet" href="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net-bs4/css/dataTables.bootstrap4.css" >

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Designations<small class="ml-3 mr-3">|</small><small>Management</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.designations.index')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">Designations</a>
          </li>
          <li class="breadcrumb-item active">Designations</li>
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
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>Designations</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('admin.designations.create')}}"><i class="fa fa-plus mr-2"></i>Create</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="datatable__tbl" class="table dataTable" width="100%" style="width: 100%;">
         <thead>
            <tr role="row">
               <th>SN</th>
               <th>Title</th>
               <th>Created at</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
          @foreach($data as $key=>$row)
            <tr role="row">
               <td>{{ $key+1}}</td>
               <td>
                 {{$row->title}}
               </td>
               <td>
                  <small>
                    {{$row->created_at->format(env('GENERAL_DATE_FORMAT'))}}
                  </small>
               </td>
               <td>
                  <div class="btn-group btn-group-sm">
                     <a href="{{route('admin.designations.edit', encrypt($row->id))}}" class="btn btn-link">
                     <i class="fa fa-edit"></i>
                     </a>
                     {{--
                     <a onclick="return confirm('Are you sure to DELETE?')" href="{{route('admin.designation.actions', [encrypt($row->id), encrypt('SoftDelete')])}}" class="btn btn-link">
                      <i class="fa fa-trash"></i>
                     </a>
                     --}}
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
@endpush

