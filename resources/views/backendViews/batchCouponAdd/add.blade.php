@extends('backendViews.layouts.app')
<link rel="stylesheet" href="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net-bs4/css/dataTables.bootstrap4.css" >

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
        <h1 class="m-0 text-dark">Batch<small class="ml-3 mr-3">|</small><small>Coupon</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">Batch Coupon</a>
          </li>
          <li class="breadcrumb-item active">Add</li>
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
          <a class="nav-link active" href=""><i class="fa fa-plus mr-2"></i>Batch Coupons</a>
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
               <th>Code</th>
               <th>Current Coupons</th>
               <th>Status</th>
               <th>Register Date</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
          @foreach($staffs as $key=>$staff)
            <tr role="row">
               <td>{{ $key+1}}</td>
               <td>{{$staff->name}}</td>
               <td>{{$staff->email}}</td>
               <td>{{$staff->phone}}</td>
               <td>{{$staff->code}}</td>
               <td>
                 @if($staff->get_staff_coupon)
                  {{$staff->get_staff_coupon->remaining_coupons}}
                 @else
                  0
                 @endif
               </td>
               <td>
                <span class="badge badge-info">{{$staff->status}}</span>
               </td>
               <td>
                  <small>
                    {{$staff->created_at->format(env('GENERAL_DATE_FORMAT'))}}
                  </small>
               </td>
               <td>
                  <div class="btn-group btn-group-sm">
                    <a title="Add Batch Coupon" href="" class="btn btn-link" data-toggle="modal" data-target="#viewUserDetailsModal-{{$staff->id}}">
                      <i class="fa fa-plus"></i>
                    </a>

                    <!-- Modal -->
                    <div class="modal fade" id="viewUserDetailsModal-{{$staff->id}}" tabindex="-1" aria-labelledby="viewUserDetailsModalLabel-{{$staff->id}}" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="viewUserDetailsModalLabel-{{$staff->id}}">Add Batch Coupon</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form class="addCouponFrom" id="addCouponFrom_{{$staff->id}}" action="{{route('admin.add.batch.coupon.post')}}" method="POST">
                              @csrf
                              <input type="hidden" name="staffID" value="{{encrypt($staff->id)}}">

                              <div class="form-group">
                                <label>* Select Batch</label><br>
                                <div class="d-flex justify-content-start">
                                  <div class="mr-5">
                                    <input id="batchInput_10" type="radio" name="batch" value="10" checked="1"> <label for="batchInput_10">10 Batch</label> 
                                  </div>
                                  <div>
                                    <input id="batchInput_20" type="radio" name="batch" value="20"> <label for="batchInput_20">20 Batch</label>
                                  </div>
                                </div>
                              </div>
                              <div>
                                <button onclick="return confirm('Are you sure?')" class="btn btn-primary btn-sm btn-block" type="submit">Add</button>
                              </div>
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


<script type="text/javascript">
   $("form.addCouponFrom").on('submit', function(e){
         e.preventDefault();
         var formID = $(this).attr('id')
         var form = $(this);
         var url = form.attr('action');
         var type = form.attr('method');
         //var form_data = form.serialize();
   
         formSubmitWithFile(formID, url, type);
     })
</script>
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/form_submitter/general-form-submit.js"></script>
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/sw_alert/sweetalert2@10.js"></script>
@endpush


