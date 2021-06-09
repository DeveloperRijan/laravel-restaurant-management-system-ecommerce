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

<?php
  $data = json_decode($order->order_data, true);
?>


<div class="checkout-page">
  <h5 class="page--heading text-uppercase" style="margin-top: 20px">
   <small>
    <b>Order ID</b> #{{$order->order_id}} <br>
    <b>Order Date : </b> {{date(env('GENERAL_DATE_FORMAT'), strtotime($order->created_at))}} <br>
    <b>Payment Type : </b> {{$order->payment_type}} <br>
    <b>Order Status : </b> <span class="badge bg-info">{{$order->status}}</span>
   </small>
  </h5>

  <div class="table-responsive">
    <table class="table checkout-tbl text-center">
      <thead>
        <tr>
          <th width="5%">SN.</th>
          <th>Product</th>
          <th>Image</th>
          <th title="Regular Price">Price</th>
          <th>Quantity</th>
          <th title="Quantity * Discount Amount">Discount</th>
          <th title="(Price * Quantity) - (Quantity * Discount Amount) = After Discount Price" width="15%">Total</th>
        </tr>
      </thead>

      
        <tbody id="checkout-render">
          @foreach($data['products'] as $key=>$row)
              <tr>
                <td>
                  <small>{{($key+1)}}</small>
                </td>
                <td>
                  <a target="_blank" href="{{$row['product']['slug']}}">
                  <small>{{$row['product']['title']}}</small>
                  </a>
                </td>
                <td>
                  <img src="{{$publicAssetsPathStart.\Config::get('constants.FILE_PATH.PRODUCT').$row['product']['image']}}" style="width: 50px; height: 30px;">
                </td>
                <td>
                  <small>
                    {{env('CURRENCY_SYMBOL').$row['product']['price']}}
                  </small>
                </td>
                <td>
                  <div class="d-flex justify-content-center qty">
                    <div>{{ $row['cart']['qty'] }}</div>
                  </div>
                </td>
                <td>
                  <small>
                    {{env('CURRENCY_SYMBOL').$row['product']['discount_price']}} ({{$row['product']['item_discount_percent']}}%) <br>
                    
                    @if($row['product']['discount_price'] > 0)
                    <span class="text-danger">- {{env('CURRENCY_SYMBOL').$row['product']['total_discount_amount']}}</span>
                    @endif
                  </small>
                </td>
                <td>
                  @if($row['product']['discount_price'] > 0)
                  <small>
                    {{env('CURRENCY_SYMBOL').$row['product']['total_amount_minus_total_dis']}}
                  </small>
                  @else
                  <small>
                    {{env('CURRENCY_SYMBOL').$row['product']['total_amount_multiply_qty']}}
                  </small>
                  @endif
                </td>
              </tr>
          @endforeach

              <tr class="special_tr">
                <td class="remove_borders" colspan="6" style="text-align: right;">
                  <small><b>Sub Total</b></small>
                </td>
                <td class="remove_borders">
                  {{env('CURRENCY_SYMBOL').$data['summary']['sub_total']}}
                </td>
              </tr>

              <tr class="special_tr">
                <td class="remove_borders" colspan="6" style="text-align: right;">
                  <small><b>Delivery Charge (+)</b></small>
                </td>
                <td class="remove_borders">
                  @if(!is_numeric($data['summary']['delivery_charge']['charge_amount']))
                    {{$data['summary']['delivery_charge']['charge_amount']}}
                  @else
                    {{env('CURRENCY_SYMBOL').$data['summary']['delivery_charge']['charge_amount']}}
                  @endif
                </td>
              </tr>

              
              <tr class="special_tr">
                <td class="remove_borders" colspan="6" style="text-align: right;">
                  <small><b>Coupon Applied (-)</b></small>
                </td>
                <td class="remove_borders text-center">
                  @if(isset($data['couponAppliedResponse']['is_applied']) && $data['couponAppliedResponse']['is_applied'] === true)
                  <small class="text-success">{{$data['couponAppliedResponse']['msg']}}</small><br>
                  <small>{{env("CURRENCY_SYMBOL").$data['couponAppliedResponse']['coupon_discount_amount']}}</small>
                  @else
                  <small class="text-info">No</small>
                  @endif
                </td>
              </tr>

              <tr class="special_tr">
                <td class="remove_borders" colspan="6" style="text-align: right;">
                  <small><b>Grand Total</b></small>
                </td>
                <td class="remove_borders">
                  <b>{{env('CURRENCY_SYMBOL').$data['summary']['grand_total']}}</b>
                </td>
              </tr>

              <tr class="special_tr">
                <td class="remove_borders" colspan="8" style="text-align: center;">
                  <small><i class="fa fa-info-circle"></i> Grand Total = ((Sub-total + Delivery Charge) - Coupon Discount)</small>
                </td>
              </tr>

            </tbody>
       

    </table>
  </div>

</div>