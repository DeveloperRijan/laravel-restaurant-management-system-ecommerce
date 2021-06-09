<div>
	<h6 class="text-center mt-3">
		<?php
			if (isset($data['summary']['grand_total'])) {
				echo "Total Bill : ".env("CURRENCY_SYMBOL").$data['summary']['grand_total'];
			}
		?>
	</h6>
</div>

<div class="d-flex justify-content-center" style="margin-top: 30px">
	<button option='paynow' type="button" class="paymentOptionsBTN activePaymentOption">Pay Now</button>
	<button option='cod' type="button" class="paymentOptionsBTN">COD (Cash on Delivery)</button>
</div>


<div id="payNow_options">
	@include("payment_gateways.paypal")
</div>
<div id="cod_option" class="d-none">
	<div class="row">
		<div class="col-lg-3"></div>
		<div class="col-lg-6">
			<form action="{{route('customer.order.post')}}" method="POST" style="margin-top: 40px">
				@csrf
				<input type="hidden" name="payment_type" value="{{encrypt('cod')}}">
				<input type="hidden" name="addressID" value="{{\Request::get('address')}}">
				<button class="btn btn-primary w-100">Confirm Order</button>
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
		}else{
			$("div#payNow_options").addClass('d-none')
			$("div#cod_option").removeClass('d-none')
		}
	})
</script>
@endpush