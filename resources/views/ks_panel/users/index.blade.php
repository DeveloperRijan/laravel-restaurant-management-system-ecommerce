@extends('ks_panel.layouts.app')

<link rel="stylesheet" href="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net-bs4/css/dataTables.bootstrap4.css" >

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Users<small class="ml-3 mr-3">|</small><small>Management</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('ks.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">Users</a>
          </li>
          <li class="breadcrumb-item active">{{ucwords(str_replace('_', ' ',\Request::get('type')))}}</li>
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
          <a class="nav-link @if(\Request::get('status') == '') active @endif " href="{{route('ks.users.index')}}?type={{\Request::get('type')}}"><i class="fa fa-list mr-2"></i>{{ucwords(str_replace('_', ' ',\Request::get('type')))}}</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="datatable__tbl" class="table dataTable" width="100%" style="width: 100%;">
         <thead>
            <tr role="row">
               <th>SN</th>
               <th>Name</th>
               <th>Email</th>
               <th>Phone</th>
               <th>Status</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
          @foreach($data as $key=>$user)
            <tr role="row">
               <td>{{ $key+1}}</td>
               <td>{{$user->name}}</td>
               <td>{{$user->email}}</td>
               <td>{{$user->phone}}</td>
               <td>
                @if($user->deleted_at != NULL)
                <span class="badge badge-danger">Blocked</span>
                @else
                <span class="badge badge-success">Active</span>
                @endif
               </td>
               <td>
                  <div class="btn-group btn-group-sm">
                    <a href="{{route('ks.user.show', encrypt($user->id))}}" class="btn btn-link">
                      <i class="fa fa-eye"></i>
                    </a>

                    <!-- Modal -->
                    <div class="modal fade" id="viewUserDetailsModal-{{$user->id}}" tabindex="-1" aria-labelledby="viewUserDetailsModalLabel-{{$user->id}}" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="viewUserDetailsModalLabel-{{$user->id}}">Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <th>Name</th>
                                  <td>:</td>
                                  <td>{{$user->name}}</td>
                                </tr>
                                <tr>
                                  <th>Email</th>
                                  <td>:</td>
                                  <td>{{$user->email}}</td>
                                </tr>
                                <tr>
                                  <th>Phone</th>
                                  <td>:</td>
                                  <td>{{$user->phone}}</td>
                                </tr>
                                @if($user->type === "Customer")
                                <tr>
                                  <th>Total Orders</th>
                                  <td>:</td>
                                  <td>{{$user->get_orders->count()}}</td>
                                </tr>
                                @endif

                                @if($user->type === "Staff")
                                <tr>
                                  <th>Address</th>
                                  <td>:</td>
                                  <td>{{$user->address_line_one.", ".$user->address_line_two}}</td>
                                </tr>
                                @endif
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

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

