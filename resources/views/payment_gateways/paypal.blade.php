@push('styls')
    <style type="text/css">
        .payment_methods_block{
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 40px
        }
        .payment_methods_block .payment_gateway{
            border-right: 1px solid #ddd;
            padding: 15px;
        }
        .payment_methods_block .encourage_block{
            padding: 15px;
        }
        .payment_methods_block .encourage_block table tr th{
            color: forestgreen
        }
        .payment_methods_block .encourage_block table tr td{
            padding-left: 10px;
        }

        @media screen and (max-width: 991px) {
            .payment_methods_block .payment_gateway
            {
                border-right: none;
            }
        }
    </style>
@endpush


{{-- place order if pay via paypal  --}}
<form id="hidden__form" action="{{route('customer.order.post')}}" method="POST">
    @csrf
    <input type="hidden" name="payment_type" value="{{encrypt('paid')}}">
    <input type="hidden" name="addressID" value="{{\Request::get('address')}}">
    <input type="hidden" name="payment" value="Paypal">
    <input type="hidden" name="p_payer_name" id="payer_name" value="">
    <input type="hidden" name="p_payer_email" id="payer_email" value="">
    <input type="hidden" name="p_payer_country" id="payer_country" value="">
    <input type="hidden" name="p_transaction_id" id="transaction_id" value="">
    <input type="hidden" name="p_paid_amount" id="paid_amount" value="">
    <input type="hidden" name="p_status" id="paid_status" value="">
</form>


<div class="row" id="paypal--pay-option">
    <div class="col-lg-1 col-md-12"></div>

    <div class="col-lg-5 col-md-12">
        <?php
            $paypalGateway = \App\Models\PaymentGateway::first();
        ?>
        <!-- Set up a container element for the button -->
        @if($paypalGateway && isset($data['summary']['grand_total']))
        <div class="payment_gateway">
            <div class="text-center text-danger"><small><i class="fas fa-info-circle"></i> Please don't refresh or leave the page when payment is processing. System will automatically redirect to you!</small></div>
            <div id="paypal-button-container"></div>
        </div>
        @else
        <p class="text-info">SORRY - Payment gateway not configured yet | please you may carry on with COD (Cash on Delivery)</p>
        @endif
    </div>

    <div class="col-lg-5 col-md-12">
        <div class="encourage_block">
            <table class="text-left">
                <tr>
                    <th><i class="fas fa-shield-alt"></i></th>
                    <td>Secure & Encrypted Data</td>
                </tr>
                <tr>
                    <th><i class="fas fa-user-lock"></i></th>
                    <td>Privacy Protected</td>
                </tr>
                <tr>
                    <th><i class="fas fa-shipping-fast"></i></th>
                    <td>Fast & reliable delivery, order now</td>
                </tr>
                <tr>
                    <th><i class="fas fa-undo-alt"></i></th>
                    <td>100% Refundable</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-lg-1 col-md-12"></div>
</div>




@push('scripts')
<!-- Include the PayPal JavaScript SDK -->
    @if($paypalGateway && isset($data['summary']['grand_total']))

        <script src="https://www.paypal.com/sdk/js?client-id={{$paypalGateway->client_id}}&disable-funding=credit,card&currency=USD"></script>

        
        <script>
            // Render the PayPal button into #paypal-button-container
            paypal.Buttons({
                style: {
                    layout:  'vertical',
                    color:   'white',
                    shape:   'rect',
                    label:   'paypal'
                },

                // Set up the transaction
                createOrder: function(data, actions) {

                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: "{{$data['summary']['grand_total']}}"
                            }
                        }]
                    });
                },

                // Finalize the transaction
                onApprove: function(data, actions) {
                    $("#form__processing__gif").show()

                    return actions.order.capture().then(function(details) {
                        // Show a success message to the buyer
                        //set all required contentets
                        if(details.status === "COMPLETED"){
                            //here payment is success, now submit hidden__form
                            //set all required contentets
                            $('form#hidden__form #payer_name').val(details.payer.name.given_name + details.payer.name.surname)
                            $('form#hidden__form #payer_email').val(details.payer.email_address)
                            $('form#hidden__form #transaction_id').val(details.purchase_units[0].payments.captures[0].id)
                            $('form#hidden__form #payer_country').val(details.purchase_units[0].shipping.address.country_code)
                            $('form#hidden__form #paid_amount').val(details.purchase_units[0].amount.value)
                            $('form#hidden__form #paid_status').val("COMPLETED")
                            
                            
                            
        
        
                            let payer_name = $("form#hidden__form #payer_name").val();
                            let payer_email = $("form#hidden__form #payer_email").val();
                            let transaction_id = $("form#hidden__form #transaction_id").val();
                            let payer_country = $("form#hidden__form #payer_country").val();
                            let paid_amount = $("form#hidden__form #paid_amount").val();
                            
                        
                            if (payer_name !== "" && payer_email !== "" && transaction_id !== "" &&
                                payer_country !== "" && paid_amount !== "") {
                                $("form#hidden__form").submit()
                            }else{
                                alert("Somethig wrong in transaction.\nPlease contact support.\nTransaction ID:"+transaction_id)
                                window.location.href = "<?php echo url('/')?>";
                            }
                            
                        }else{
                            alert("SORRY !! Your payment is not completed")
                            window.location.href = "<?php echo url('/')?>";
                        }
                        
                    });
                }


            }).render('#paypal-button-container');
        </script>
    @endif

@endpush