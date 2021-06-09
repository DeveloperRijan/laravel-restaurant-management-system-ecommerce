@extends('backendViews.layouts.app')

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
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
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
          <a class="nav-link @if(\Request::get('status') == '') active @endif " href="{{route('admin.users.index')}}?type={{\Request::get('type')}}"><i class="fa fa-list mr-2"></i>{{ucwords(str_replace('_', ' ',\Request::get('type')))}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if(\Request::get('status') === 'blocked') active @endif " href="{{route('admin.users.index')}}?type={{\Request::get('type')}}&status=blocked"><i class="fa fa-list mr-2"></i>Blocked {{ucwords(str_replace('_', ' ',\Request::get('type')))}}</a>
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
               <th>Register Date</th>
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
                <span class="badge badge-info">{{$user->status}}</span>
                @endif
               </td>
               <td>
                  <small>
                    {{$user->created_at->format(env('GENERAL_DATE_FORMAT'))}}
                  </small>
               </td>
               <td>
                  <div class="btn-group btn-group-sm">
                    <a href="{{route('admin.users.show', encrypt($user->id))}}" class="btn btn-link">
                      <i class="fa fa-eye"></i>
                    </a>

                    @if($user->type === "Staff")
                      @if($user->status === "Pending")
                        <a onclick="return confirm('Are you sure to active account?')" title="Activate the staff account" href="{{route('admin.user.actions', [encrypt($user->id), encrypt('Active')] )}}" class="btn btn-link">
                          <i class="fa fa-check"></i>
                        </a>
                      @endif
                    @endif

                    @if($user->deleted_at != NULL)
                    <a title="Restore the user" onclick="return confirm('Are you sure to UNBLOCK?')" href="{{route('admin.user.actions', [encrypt($user->id), encrypt('Unblock')])}}" class="btn btn-link">
                      <i class="fa fa-undo"></i>
                    </a>
                    @else
                    <a onclick="return confirm('Are you sure to BLOCK?\nRemember : Once you block this user, then can not login anymore until you unblock!')" href="{{route('admin.user.actions', [encrypt($user->id), encrypt('SoftDelete')])}}" class="btn btn-link">
                      <i class="fa fa-trash"></i>
                    </a>
                    @endif

                    <a title="Update Password" href="" class="btn btn-link"
                    data-toggle="modal" data-target="#passworUpdateForm-{{$user->id}}">
                      <i class="fa fa-lock"></i>
                    </a>

                    <!-- Modal -->
                    <div class="modal fade" id="passworUpdateForm-{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel-{{$user->id}}" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel-{{$user->id}}">Update User Password</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="{{route('admin.user.pass.update')}}" method="POST">
                              @csrf
                              <input type="hidden" name="user_id" value="{{encrypt($user->id)}}">
                              <div class="form-group">
                                <input type="password" name="password" class="form-control" required="1" min="8" placeholder="New Password">
                              </div>
                              <button class="btn btn-primary btn-sm">Update</button>
                            </form>
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

