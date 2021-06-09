<form>
	<div class="row">

		<div class="col-lg-12 col-md-12 mt-3">
			<div class="form-group">
				<label><b>Item/Product</b></label>
				<div class="form-group">
					<select id="selectedProductID" class="form-control" name="product">
						<option value="">Select Food</option>
						@foreach($allItems as $key=>$item)
							<option @if($selectedItem && $selectedItem->id == $item->id) selected @endif value="{{encrypt($item->id)}}">{{$item->title}} | {{$item->item_type}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>


		<div class="col-lg-12 col-md-12 pair--block">
			<div class="form-group">
				<label><b>Checkout Summary</b></label>
				<div class="table-responsive">
				    <table class="table checkout-tbl text-center">
				      <thead>
				        <tr>
				          <th>Food</th>
				          <th>Image</th>
				          <th title="Regular Price">Price</th>
				          <th>Total</th>
				        </tr>
				      </thead>
				      
				        <tbody id="checkout-render">
				          @include("frontendViews.staff.partials.checkout.checkout_data")
				        </tbody>
				    </table>
				</div>
			</div>
		</div>

		<div class="col-lg-12 col-md-12 pair--block">
	    	<div class="form-group">
	    		<label><b>Select Time (ASAP) or Schedule</b></label>
		    	<select onchange="controlSchedule(this.value)" class="form-control" name="delivery_time">
		    		<option value="ASAP" selected="1">ASAP (As Soon As Possible)</option>
		    		<option value="Schedule">Schedule</option>
		    	</select>
		    	<div class="schedule_block mt-3 d-flex justify-content-between d-none">
		    		<input type="date" name="schedule_date" class="form-control">
		    		<input type="time" name="schedule_time" class="form-control">
		    	</div>
	    	</div>
	    </div>

	    <div class="col-lg-12 col-md-12 pair--block">
	    	<div class="form-group">
	    		<label><b>Delivery Type</b></label>
		    	<select class="form-control" name="delivery_type">
		    		<?php
		    			if (\Auth::check()) {
		    				if (\App\Models\StaffAllowedDeliveryOrder::where('code', Auth::user()->code)->exists()) {
		    					echo "<option value='Collection' selected='1'>Collection</option>";
		    					echo "<option value='Delivery'>Delivery</option>";
		    				}else{
		    					echo "<option value='Collection' selected='1'>Collection</option>";
		    				}
		    			}else{
		    				echo "<option value='Collection' selected='1'>Collection</option>";
		    			}
		    		?>
		    	</select>
	    	</div>
	    </div>

		<div class="col-lg-12 col-md-12 mt-5 pair--block">
			<div class="row">
			    <div class="col-lg-3 col-md-12"></div>
			    <div class="col-lg-6 col-md-12">
			    	@if (Auth::check())
			    		<input type="hidden" name="step" value="address">
			    		<button class="proceed_next_link" type="submit">Proceed to Next <i class="fas fa-arrow-circle-right"></i></button>
			      	@else
			      		<a class="proceed_next_link _showLoginModal" href="">Proceed to Next <i class="fas fa-arrow-circle-right"></i> </a>
			  		@endif
			    </div>
			    <div class="col-lg-3 col-md-12"></div>
			</div>
		</div>

	</div>
</form>



@push("scripts")
<script type="text/javascript">
	$("select#selectedProductID").on("change", function(){
	 	let value = $(this).val();
	 	if (value == '') {
	 		$("div.pair--block").addClass('d-none')
	 	}else{
	 		//ajax request to render checkout summary
	 		renderStaffCheckoutSummary()
	 		$("div.pair--block").removeClass('d-none')
	 	}
	})



	function controlSchedule(value){
		if (value === "Schedule") {
			$("div.schedule_block").removeClass("d-none")
		}else{
			$("div.schedule_block").addClass("d-none")
		}
	}


	$("tbody#checkout-render").on('click', "button#apply_coupon_code_btn", function(e){
		e.preventDefault()
		let action = $(this).attr("action")
		renderStaffCheckoutSummary(action)
	})

	//coupon apply or remove
	function renderStaffCheckoutSummary(type){
		let selectedProductID = $("select#selectedProductID").val()
		//window.location.href = "{{route('staff.order.page')}}?product_id="+selectedProductID+"&coupon=use"
		$.ajax({
			url:"{{route('staff.order.page')}}?product_id="+selectedProductID+"&coupon="+type,
			dataType:"HTML",
			cache:false,
			beforeSend:function(){
				$("#form__processing__gif").show()
			},
			success:function(response){
				$("#form__processing__gif").hide()
				$("tbody#checkout-render").html(response)
			},
			error:function(){
				$("#form__processing__gif").hide()
				alert("Something wrong")
				console.log("Error")
			},
			complete:function(){
				$("#form__processing__gif").hide()
			}
		})
	}

	
</script>
@endpush