@extends("frontendViews.layouts.master")

@push("styles")
<style type="text/css">
  .checkout-page .checkout-heading{
    text-align: center;
    text-transform: uppercase;
    padding: 10px;
    margin: 30px 0px 0px 0px;
    border-bottom: 1px solid #ddd;
  }
  .checkout-page table.checkout-tbl thead{
    background-color: #efefef
  }

  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }


  /*design qty control buttons*/
  .checkout-page .qty button{
    background: transparent;
    border: 1px solid #ddd;
    padding: 0;
    width: 25px;
    height: 25px;
    font-size: 14px;
    border-radius: 50%;
  }
  .checkout-page .qty div{
    margin: 0px 5px
  }



  .checkout-page input.coupon_code_input{
    padding: 2px 5px;
    border: 1px dashed #ddd;
    border-radius: 3px;
    outline: none;
  }
  .checkout-page button#apply_coupon_code_btn{
    width: 100%;
    border: 1px solid forestgreen;
    background: #dc4e1c;
    color: #fff;
    text-transform: uppercase;
    padding: 5px;
    border-radius: 3px;
    margin-top: 8px;
    outline: none;
  }
  .checkout-page td.remove_borders{
    border: none !important;
  }

  .checkout-page  tr.special_tr{
    background-color: #FBFAF1 !important
  }

  .checkout-page  .address_options div:nth-child(1){
    width: 60%
  }
  .checkout-page  .address_options div:nth-child(2){
    width: 40%
  }
  .checkout-page  .address_options div:nth-child(2) button{
    width: 100%;
    margin: 25px 0;
    padding: 5px 10px;
    border-radius: 3px;
    border: 1px dashed #ddd;
    outline: none;
  }

  .checkout-page  select.address{
    width: 100%;
    margin: 25px 0;
    padding: 5px 10px;
    border-radius: 3px;
    border: 1px dashed #ddd;
    outline: none;
  }

  .checkout-page .proceed_next_link{
    width: 100%;
    display: block;
    text-align: center;
    background: #dc4e1c;
    padding: 5px;
    border-radius: 3px;
    color: #fff;
    text-decoration: none;
  }

  .form-group{
    margin-bottom: 15px
  }


  .encourage_block th{
    color: #dc4e1c
  }
  .encourage_block th,
  .encourage_block td
  {
    margin-bottom: 7px
  }

  .payment_gateway{
    padding: 20px;
    border-right: 1px solid #ddd;
    margin: 10px;
    padding-right: 60px
  }
  .encourage_block{
    padding: 15px;
    margin: 10px;
  }


  button.paymentOptionsBTN{
    width: 200px;
    border: none;
    outline: none;
    padding: 10px;
    background-color: transparent;
    border: 1px dashed #ddd;
  }
  button.activePaymentOption{
    background-color: #dc4e1c;
    color: #fff;
    border:1px solid #dc4e1c;
  }
  button.paymentOptionsBTN:hover{
    background: transparent;
    color: #dc4e1c;
    border: 1px dashed #dc4e1c;
  }
</style>
@endpush

@section("content")

<div class="inner_popular container checkout-page" style="margin-bottom: 120px">
  <div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="text-center" style="margin-top: 20px">
          @include("msg.msg")

          @if(\Session::has('checkout_some_cart_items_deleted'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session()->get('checkout_some_cart_items_deleted') }}
          </div>
          @endif
          
        </div>

      @if(\Request::get('step') == 'address')
      <h4 class="checkout-heading">Checkout - (Addresses)</h4>
      @elseif(\Request::get('step') == 'payment')
      <h4 class="checkout-heading">Checkout - (Payment)</h4>
      @else
      <h4 class="checkout-heading">Checkout - (Items Detail)</h4>
      @endif
    </div>

    @if(\Request::get('step') == 'address')
      @include("frontendViews.checkout.partials.addresses")
    @elseif(\Request::get('step') == 'payment')
      @include("frontendViews.checkout.partials.payment_gateway")
    @else
      @include("frontendViews.checkout.partials.items_review")
    @endif


  </div>
</div>

@endsection


@push("scripts")
<script type="text/javascript" src="{{$publicAssetsPathStart}}frontend/js/checkout_control.js"></script>
@endpush