@extends('backendViews.layouts.app')

@push("styles")
<link rel="stylesheet" href="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net-bs4/css/dataTables.bootstrap4.css" >
<style type="text/css">
  input[type='time']{
    border: 1px solid #ddd;
    padding: 3px;
    border-radius: 3px;
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
        <h1 class="m-0 text-dark">Company<small class="ml-3 mr-3">|</small><small>Management</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">Admin</a>
          </li>
          <li class="breadcrumb-item active">Companies</li>
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
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>Companies</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('admin.products.create')}}"><i class="fa fa-plus mr-2"></i>Inactive List</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href=""
          type="button" data-toggle="modal" data-target="#addNewCompanyModal"><i class="fa fa-plus mr-2"></i>Add New</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="datatable__tbl" class="table dataTable" width="100%" style="width: 100%;">
         <thead>
            <tr role="row">
               <th><small>SN</small></th>
               <th><small>Name</small></th>
               <th><small>Code</small></th>
               <th><small>City</small></th>
               <th><small>State</small></th>
               <th><small>Status</small></th>
               <th><small>Discount</small></th>
               <th><small>Actions</small></th>
            </tr>
         </thead>
         <tbody>
          @foreach($data as $key=>$company)
            <tr role="row">
               <td><small>{{ $key+1}}</small></td>
               <td><small>{{$company->name}}</small></td>
               <td><small>{{$company->code}}</small></td>
               <td><small>{{$company->city}}</small></td>
               <td><small>{{$company->state}}</small></td>
               <td>
                 <span class="badge {{ ($company->status === 'Active' ? 'badge-success' : 'badge-danger') }}">{{$company->status}}</span>
               </td>
               <td>
                  <div class="btn-group btn-group-sm">
                     <a href="{{route('admin.products.edit', encrypt($company->id))}}" class="btn btn-link">
                     <i class="fa fa-edit"></i>
                     </a>

                     <a onclick="return confirm('Are you sure to DELETE?\nRemember : The action will not be revert!')" href="{{route('admin.product.action', [encrypt($company->id), encrypt('SoftDelete')])}}" class="btn btn-link">
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
<div class="modal fade" id="addNewCompanyModal" tabindex="-1" aria-labelledby="addNewPostCodeLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addNewPostCodeLabel">Add New</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addNewCompanyForm" action="{{route('admin.companies.store')}}" method="POST">
          @csrf
          <div class="form-group">
            <label>* <small>Name</small></label>
            <input type="text" name="name" placeholder="Name" class="form-control" required="1" maxlength="99">
          </div>

          <div class="form-group">
            <label>* <small>Code</small></label>
            <input type="text" name="code" placeholder="Code" required="1" class="form-control">
          </div>

          <div class="form-group">
            <label>* <small>Address line one</small></label>
            <input type="text" name="address_line_one" placeholder="Address line one" required="1" class="form-control">
          </div>

          <div class="form-group">
            <label><small>Address line two</small></label>
            <input type="text" name="address_line_two" placeholder="Address line two" class="form-control">
          </div>

          <div class="form-group">
            <label>* <small>City</small></label>
            <input type="text" name="city" placeholder="City" class="form-control">
          </div>

          <div class="form-group">
            <label>* <small>State</small></label>
            <input type="text" name="state" placeholder="State" class="form-control">
          </div>

          <div class="form-group">
             <div>
                <div class="d-flex justify-content-start">
                   <div><i class="zmdi fas fa-clock"></i></div>
                   <label>* <small>Can Order Any Time</small></label>
                </div>
             </div>

              <div>
                 <input checked="1" value="Yes" type="radio" name="can_order_any_time" id="can_order_any_time_yes">
                 <label for="can_order_any_time_yes"><small>Yes</small></label>
                 <input value="No" type="radio" name="can_order_any_time" id="can_order_any_time_no">
                 <label for="can_order_any_time_no"><small>No</small></label>
              </div>

             <div class="allocate_hrs_input_block d-none" style="padding: 3px; border: 1px solid #ddd;">
                <label><small>* Company Allowcated Hours</small></label>
                <div class="d-flex justify-content-center mb-2">
                   <div>
                     <input type="time" name="start_time" placeholder="* Company Allocated Hours">
                   </div>
                   <div class="m-1">
                     To
                   </div>
                   <div>
                     <input type="time" name="end_time" placeholder="* Company Allocated Hours">
                   </div>
                </div>
                <div class="d-flex justify-content-center">
                   <div>
                     <select name="start_day" class="form-control">
                        @foreach(\Config::get("constants.WEEK_DAYS") as $key=>$day)
                           <option value="{{$day}}">{{$day}}</option>
                        @endforeach
                     </select>
                   </div>
                   <div class="m-1">To</div>
                   <div>
                     <select name="end_day" class="form-control">
                        @foreach(\Config::get("constants.WEEK_DAYS") as $key=>$day)
                           <option value="{{$day}}">{{$day}}</option>
                        @endforeach
                     </select>
                   </div>
                </div>
             </div>
          </div>

          <div class="form-group">
            <label><small>* Discount %</small></label>
            <input type="number" name="discount_percent" step="0.01" required="1" class="form-control">
            <small class="text-danger">Note : The discount percent will be execute of the staff's of this company during ordering</small>
          </div>
          <button class="btn btn-primary btn-sm" type="submit">Create</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection


@push("scripts")
<script type="text/javascript">
   $("form input[name='can_order_any_time']").on("click", function(){
      if ($(this).val() === "Yes") {
         $("div.allocate_hrs_input_block").addClass("d-none")
      }else{
         $("div.allocate_hrs_input_block").removeClass("d-none")
      }
   })
</script>

<script type="text/javascript">
   $("#addNewCompanyModal form#addNewCompanyForm").on('submit', function(e){
         e.preventDefault();
         var form = $(this);
         var url = form.attr('action');
         var type = form.attr('method');
         //var form_data = form.serialize();
   
         formSubmitWithFile("addNewCompanyForm", url, type);
     })
</script>

<!-- datatable scripts -->
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/config_js/datatable_config.js"></script>


<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/form_submitter/general-form-submit.js"></script>
    <script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/sw_alert/sweetalert2@10.js"></script>
@endpush

