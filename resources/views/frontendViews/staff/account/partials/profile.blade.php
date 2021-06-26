@push("styles")
<style type="text/css">
	div.form-group{
		margin-bottom: 15px
	}
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

<div class="d-flex justify-content-between mb-2">
	<div>
		<h5>My Profile</h5>
	</div>
	<div>
		<button class="btn btn-info btn-sm" id="profileShowBTN">Profile</button>
		<a href="{{route('staff.account.get')}}?data=password" class="btn btn-secondary btn-sm">Update Password</a>
	</div>
</div>
<div class="table-responsive">
<?php
	$user = \Auth::user();
?>
	<form method="POST" action="{{route('staff.profile.update')}}" style="padding: 15px">
        @csrf
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

	
</div>
