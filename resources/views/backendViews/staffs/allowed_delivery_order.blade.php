@extends('backendViews.layouts.app')

<link rel="stylesheet" href="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net-bs4/css/dataTables.bootstrap4.css" >

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Staff<small class="ml-3 mr-3">|</small><small>Allowed Delivery Orders</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">Delivery</a>
          </li>
          <li class="breadcrumb-item active">Orders</li>
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
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>Allowed Codes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="" type="button" data-toggle="modal" data-target="#addNewModal"><i class="fa fa-plus mr-2"></i>Add New</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="datatable__tbl" class="table dataTable" width="100%" style="width: 100%;">
         <thead>
            <tr role="row">
               <th><small>SN</small></th>
               <th><small>Code</small></th>
               <th><small>Created at</small></th>
               <th><small>Actions</small></th>
            </tr>
         </thead>
         <tbody>
          @foreach($allowedCodes as $key=>$code)
            <tr role="row">
               <td>{{ $key+1}}</td>
               <td>{{$code->code}}</td>
               <td>
                  <small>
                    {{$code->created_at->format(env('GENERAL_DATE_FORMAT'))}}
                  </small>
               </td>
               <td>
                  <div class="btn-group btn-group-sm">
                     <a onclick="return confirm('Are you sure to DELETE?\nRemember : The action will not be revert!')" href="{{route('admin.staff.allowedForDelivery.delete', [encrypt($code->id), encrypt('Delete')])}}" class="btn btn-link">
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

<!-- Modal -->
<div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="addNewPostCodeLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addNewPostCodeLabel">Add New</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('admin.staff.allowedForDelivery.order.post')}}" method="POST">
          @csrf
          <div class="form-group">
            <label>* Code to be Allowed</label>
            <input type="text" name="code" placeholder="Code" class="form-control" required="1" maxlength="99">
          </div>
          <button class="btn btn-primary btn-sm" type="submit">Add</button>
        </form>
      </div>
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

