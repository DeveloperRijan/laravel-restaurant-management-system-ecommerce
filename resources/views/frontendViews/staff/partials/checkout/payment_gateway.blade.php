<div class="d-flex justify-content-center" style="margin-top: 30px">
	<button option='paynow' type="button" class="paymentOptionsBTN activePaymentOption">Pay Now</button>
	<button option='cod' type="button" class="paymentOptionsBTN">COD (Cash on Delivery)</button>
	<button option='credit' type="button" class="paymentOptionsBTN">Credit Balance</button>
</div>


<div id="payNow_options">
	@include("payment_gateways.paypal_staff_checkout")
</div>
<div id="cod_option" class="d-none">
	<div class="row">
		<div class="col-lg-3"></div>
		<div class="col-lg-6">
			<form action="{{route('staff.order.post')}}" method="POST" style="margin-top: 40px">
				@csrf
				<input type="hidden" name="payment_type" value="{{encrypt('cod')}}">
				<button class="btn btn-primary w-100">Confirm (COD) Order</button>
			</form>
		</div>
		<div class="col-lg-3"></div>
	</div>
</div>
<div id="credit_option" class="d-none">
	<div class="row">
		<div class="col-lg-3"></div>
		<div class="col-lg-6">
			<br>
			@if($staffCreditBalance)
			<p>Your Credit Balance is : {{env('CURRENCY_SYMBOL').$staffCreditBalance->remaining_balance}}</p>
			@else
			<p>Your Credit Balance is : {{env('CURRENCY_SYMBOL')}}0</p>
			@endif
			<form action="{{route('staff.order.post')}}" method="POST" style="margin-top: 40px">
				@csrf
				<input type="hidden" name="payment_type" value="{{encrypt('credit')}}">
				<button class="btn btn-primary w-100">Confirm (Credit) Order</button>
			</form>
		</div>
		<div class="col-lg-3"></div>
	</div>
</div>



@push("scripts")
<script type="text/javascript">
	$("button.paymentOptionsBTN").on("click", function(){
		$("button.paymentOptionsBTN").removeClass('activePaymentOption')
		$(this).addClass('activePaymentOption')

		if ($(this).attr('option') === 'paynow') {
			$("div#payNow_options").removeClass('d-none')
			$("div#cod_option").addClass('d-none')
			$("div#credit_option").addClass('d-none')
		}else if($(this).attr('option') === 'cod'){
			$("div#payNow_options").addClass('d-none')
			$("div#cod_option").removeClass('d-none')
			$("div#credit_option").addClass('d-none')
		}else if($(this).attr('option') === 'credit'){
			$("div#payNow_options").addClass('d-none')
			$("div#cod_option").addClass('d-none')
			$("div#credit_option").removeClass('d-none')
		}else{
			alert("Something wrong")
			window.location.reload(true)
		}
	})
</script>
@endpush