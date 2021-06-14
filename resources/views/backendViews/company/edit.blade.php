@extends('backendViews.layouts.app')

@push("styles")
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
          <li class="breadcrumb-item active">Edit</li>
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
          <a class="nav-link" href="{{route('admin.companies.index')}}?status=Active"><i class="fa fa-list mr-2"></i>Companies</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href=""><i class="fa fa-edit mr-2"></i>Edit Company</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      
      <form id="addNewCompanyForm" action="{{route('admin.companies.update', encrypt($company->id))}}" method="POST">
        @csrf
        @method("PUT")
        <div class="form-group">
          <label>* <small>Name</small></label>
          <input value="{{$company->name}}" type="text" name="name" placeholder="Name" class="form-control" required="1" maxlength="99">
        </div>

        <div class="form-group">
          <label>* <small>Code</small></label>
          <input value="{{$company->code}}" type="text" name="code" placeholder="Code" required="1" class="form-control">
        </div>

        <div class="form-group">
          <label>* <small>Address line one</small></label>
          <input value="{{$company->address_line_one}}" type="text" name="address_line_one" placeholder="Address line one" required="1" class="form-control">
        </div>

        <div class="form-group">
          <label><small>Address line two</small></label>
          <input value="{{$company->address_line_two}}" type="text" name="address_line_two" placeholder="Address line two" class="form-control">
        </div>

        <div class="form-group">
          <label>* <small>City</small></label>
          <input value="{{$company->city}}" type="text" name="city" placeholder="City" class="form-control">
        </div>

        <div class="form-group">
          <label>* <small>State</small></label>
          <input value="{{$company->state}}" type="text" name="state" placeholder="State" class="form-control">
        </div>

        <div class="form-group">
           <div>
              <div class="d-flex justify-content-start">
                 <div><i class="zmdi fas fa-clock"></i></div>
                 <label>* <small>Can Order Any Time</small></label>
              </div>
           </div>

            <div>
               <input @if($company->can_order_any_time === "Yes") checked @endif value="Yes" type="radio" name="can_order_any_time" id="can_order_any_time_yes">
               <label for="can_order_any_time_yes"><small>Yes</small></label>
               <input @if($company->can_order_any_time === "No") checked @endif value="No" type="radio" name="can_order_any_time" id="can_order_any_time_no">
               <label for="can_order_any_time_no"><small>No</small></label>
            </div>

           <div class="allocate_hrs_input_block 
           @if($company->can_order_any_time === 'Yes')
            d-none
           @endif

           " style="padding: 3px; border: 1px solid #ddd;">
              <label><small>* Company Allowcated Hours</small></label>
              <div class="d-flex justify-content-center mb-2">
                 <div>
                   <input value="{{date('H:i', strtotime($company->start_time))}}" type="time" name="start_time" placeholder="* Company Allocated Hours">
                 </div>
                 <div class="m-1">
                   To
                 </div>
                 <div>
                   <input value="{{date('H:i', strtotime($company->end_time))}}" type="time" name="end_time" placeholder="* Company Allocated Hours">
                 </div>
              </div>
              <div class="d-flex justify-content-center">
                 <div>
                   <select name="start_day" class="form-control">
                      @foreach(\Config::get("constants.WEEK_DAYS") as $key=>$day)
                        @if($company->start_day === $day)
                          <option selected="1" value="{{$day}}">{{$day}}</option>
                        @else
                          <option value="{{$day}}">{{$day}}</option>
                        @endif
                      @endforeach
                   </select>
                 </div>
                 <div class="m-1">To</div>
                 <div>
                   <select name="end_day" class="form-control">
                      @foreach(\Config::get("constants.WEEK_DAYS") as $key=>$day)
                        @if($company->end_day === $day)
                          <option selected="1" value="{{$day}}">{{$day}}</option>
                        @else
                          <option value="{{$day}}">{{$day}}</option>
                        @endif
                      @endforeach
                   </select>
                 </div>
              </div>
           </div>
        </div>

        <div class="form-group">
          <label><small>* Discount %</small></label>
          <input value="{{$company->discount_percent}}" type="number" name="discount_percent" step="0.01" required="1" class="form-control">
          <small class="text-danger">Note : The discount percent will be execute of the staff's of this company during ordering</small>
        </div>
        <button class="btn btn-primary btn-sm" type="submit">Update</button>
      </form>


      <div class="clearfix"></div>
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
   $("form#addNewCompanyForm").on('submit', function(e){
         e.preventDefault();
         var form = $(this);
         var url = form.attr('action');
         var type = form.attr('method');
         //var form_data = form.serialize();
   
         formSubmitWithFile("addNewCompanyForm", url, type);
     })
</script>

<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/form_submitter/general-form-submit.js"></script>
    <script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/sw_alert/sweetalert2@10.js"></script>
@endpush

