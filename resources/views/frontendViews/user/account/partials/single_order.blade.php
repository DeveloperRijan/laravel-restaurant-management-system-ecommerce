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

@push("styles")
<style type="text/css">
  textarea {
    resize: none;
  }
</style>
@endpush

@endpush

<?php
  $data = json_decode($order->order_data, true);
?>



<div class="card-body">

  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Order Data</button>
    </li>
    @if($order->get_payment)
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Payment</button>
    </li>
    @endif
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Address</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
      @include("frontendViews.user.account.orders.order_data")
    </div>
    @if($order->get_payment)
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
      @include("frontendViews.user.account.orders.payment_data")
    </div>
    @endif
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
      @include("frontendViews.user.account.orders.shipping_address")
    </div>
  </div>



  <div class="clearfix"></div>
</div>


