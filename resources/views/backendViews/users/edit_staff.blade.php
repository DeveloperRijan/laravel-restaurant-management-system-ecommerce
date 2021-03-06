@extends('backendViews.layouts.app')

@push("styles")
<style type="text/css">
  .allocated_hrs_block input,
  .allocated_hrs_block select
  {
    border: 1px solid #ddd;
    outline: none;
  }

  @media screen and (max-width: 767px) {
    .allocated_hrs_block .wrapper__{
      display: block !important;
      text-align: center;
    }
  }
</style>
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">{{$user->type}}<small class="ml-3 mr-3">|</small><small>Details</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">{{$user->type}}</a>
          </li>
          <li class="breadcrumb-item active">Details</li>
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
          <a class="nav-link" href="{{route('admin.users.index')}}?type={{$user->type}}"><i class="fa fa-list mr-2"></i>{{$user->type}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="">Details</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
          
        <form method="POST" action="{{route('admin.users.update', encrypt($user->id))}}">
            @csrf
            @method("PUT")
            <div class="form-group">
               <label for="name"><i class="zmdi fa fa-user"></i> Name *</label>
               <input value="{{$user->name}}" type="text" name="name" id="name" placeholder="* Your Name" class="form-control">
            </div>
            <div class="form-group">
               <label for="email"><i class="zmdi fa fa-envelope"></i> Email *</label>
               <input value="{{$user->email}}" type="email" name="email" id="email" placeholder="* Your Email" class="form-control">
            </div>
            <div class="form-group">
               <label for="phone"><i class="zmdi fa fa-phone"></i> Phone *</label>
               <input value="{{$user->phone}}" type="tel" name="phone" id="phone" placeholder="* Your Phone" class="form-control">
            </div>
            <div class="form-group">
               <label for="code"><i class="zmdi fa fa-map-pin"></i> Company Code *</label>
               <input value="{{$user->code}}" type="text" name="code" id="code" placeholder="* Company Code" class="form-control">
            </div>
            <div class="form-group">
               <label for="code"><i class="zmdi fa fa-pencil-alt"></i> Company Name *</label>
               <input value="{{$user->company_name}}" type="text" name="company_name" id="company_name" placeholder="* Company Name" class="form-control">
            </div>

            
            <div class="form-group">
               <label for="address_line_one"><i class="zmdi fa fa-map"></i> Address line one *</label>
               <input value="{{$user->address_line_one}}" type="text" name="address_line_one" id="address_line_one" placeholder="* Address line one" class="form-control">
            </div>
            <div class="form-group">
               <label for="address_line_two"><i class="zmdi fa fa-map"></i> Address line two</label>
               <input value="{{$user->address_line_two}}" type="text" name="address_line_two" id="address_line_two" placeholder="Address line two" class="form-control">
            </div>
            <div class="form-group">
               <label for="city"><i class="zmdi fa fa-map-marker"></i> City *</label>
               <input value="{{$user->city}}" type="text" list="cities_list" name="city" id="city" placeholder="* City" class="form-control">
               <datalist list="cities_list" id="cities_list">
                  @foreach(\Config::get("constants.SEPECIAL_CITIES") as $key=>$city)
                    <option value="{{$city}}">{{$city}}</option>
                  @endforeach
               </datalist>
            </div>
            <div class="form-group">
               <label for="state"><i class="zmdi fa fa-map-marker"></i> State *</label>
               <input value="{{$user->state}}" type="text" name="state" id="state" placeholder="* State" class="form-control">
            </div>


            <div class="form-group allocated_hrs_block">
              <div class="text-center">
                <label><i class="zmdi fa fa-clock-alt"></i> Company Allowcated Hours *</label>
              </div>

              <div class="">
                <small><span>Can Order Any Time</span></small><br>
                <input @if($user->can_order_any_time === "Yes") checked="1" @endif type="radio" name="can_order_any_time" value="Yes" class="mr-3"> Yes 
                <input @if($user->can_order_any_time === "No") checked="1" @endif type="radio" name="can_order_any_time" value="No"> No 
              </div>

                <div class="allocate_hrs_input_block d-none">
                   <div class="d-flex justify-content-center wrapper__">
                      
                      <div class="mr-2 mb-2">
                        <input value="{{$user->start_time}}" type="time" name="start_time" id="company_allocated_time" placeholder="* Company Allocated Hours">
                        <span>to</span>
                        <input value="{{$user->end_time}}" type="time" name="end_time" id="company_allocated_time" placeholder="* Company Allocated Hours">
                      </div>

                      <div>
                        <select name="start_day">
                           @foreach(\Config::get("constants.WEEK_DAYS") as $key=>$day)
                              @if($user->start_day === $day)
                                <option selected="1" value="{{$day}}">{{$day}}</option>
                              @else
                                <option value="{{$day}}">{{$day}}</option>
                              @endif
                           @endforeach
                        </select>
                        <span>to</span>
                        <select name="end_day">
                           @foreach(\Config::get("constants.WEEK_DAYS") as $key=>$day)
                              @if($user->end_day === $day)
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
               <label for="designation"><i class="zmdi fa fa-user-shield"></i> Designation *</label>
               <select name="designation" id="designation" class="form-control">
                  <option value="">Select</option>
                  <?php
                     //get designatins
                     $designations = \App\Models\Designation::orderBy("title", "ASC")->get();
                     foreach ($designations as $key => $des) {
                        if ($user->designation_id == $des->id) {
                          echo "<option selected value='".$des->id."'>".$des->title."</option>";
                        }else{
                          echo "<option value='".$des->id."'>".$des->title."</option>";
                        }
                     }
                  ?>
               </select>
            </div>

            <div class="form-group form-button">
               <input type="submit" class="btn btn-primary btn-sm" value="Update">
            </div>
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
         $(this).val("No")
      }
   })
</script>
@endpush


