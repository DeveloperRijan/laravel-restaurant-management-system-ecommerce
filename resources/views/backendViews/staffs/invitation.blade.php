@extends('backendViews.layouts.app')

<link rel="stylesheet" href="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net-bs4/css/dataTables.bootstrap4.css" >

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Staff<small class="ml-3 mr-3">|</small><small>Invitations</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="#">Staffs</a>
          </li>
          <li class="breadcrumb-item active">Invitations</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">
  <div class="clearfix"></div>
  @include("msg.msg")
  @if(\Session::has("invitation_success"))
    <div class="text-center alert alert-success">
      <div><span style="font-size: 30px"><i class="fa fa-info-circle"></i></span></div>
      <p class="m-0">
        <?php
          $sessionMsg = \Session::get("invitation_success");
          echo $sessionMsg['msg']."<br>";
          echo "#".$sessionMsg['code'];
        ?>
      </p>
    </div>
  @endif

  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
        <li class="nav-item">
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>Invitations</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="" data-toggle="modal" data-target="#inviteStaffModal"><i class="fa fa-plus mr-2"></i>Invite</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="datatable__tbl" class="table dataTable" width="100%" style="width: 100%;">
         <thead>
            <tr role="row">
               <th>SN</th>
               <th>Staff ID (Code)</th>
               <th>Email</th>
               <th>Status</th>
               <th title="Date of Invitation to register">Date</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
          @foreach($invitations as $key=>$row)
            <tr role="row">
               <td>{{ $key+1}}</td>
               <td>{{$row->staff_id}}</td>
               <td>{{$row->email}}</td>
               <td>
                 <span class="badge {{ ($row->status === 'Pending' ? 'badge-warning' : 'badge-success') }}">{{$row->status}}</span>
               </td>
               <td>
                  <small>
                    {{$row->created_at->format(env('GENERAL_DATE_FORMAT'))}}
                  </small>
               </td>
               <td>
                  <div class="btn-group btn-group-sm">
                    @if($row->status === "Pending")
                     <a onclick="return confirm('Are you sure to DELETE?\nRemember : The action will not be revert!')" href="{{route('admin.product.action', [encrypt($row->id), encrypt('Delete')])}}" class="btn btn-link">
                      <i class="fa fa-trash"></i>
                     </a>
                    @endif
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
<div class="modal fade" id="inviteStaffModal" tabindex="-1" aria-labelledby="inviteStaffModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="inviteStaffModalLabel">Get Staff ID (Code) to Register</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('admin.staffs.store')}}" method="POST">
          @csrf
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" placeholder="Name of staff" required="1" class="form-control">
          </div>
          <div class="form-group">
            <label>Email <small>(optional)</small></label>
            <input type="email" name="email" placeholder="Staff email" class="form-control">
            <small class="text-danger">Note : If you enter staff email ID then system will send invitation email to the email.</small>
          </div>
          <div class="form-group">
            <label>Designation <small>(optional)</small></label>
            <input type="text" name="disgnation" placeholder="ex: Buss Driver" class="form-control">
          </div>
          <div class="form-group">
            <button class="btn btn-primary btn-sm" type="submit">Get Staff ID (Code)</button>
          </div>
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

