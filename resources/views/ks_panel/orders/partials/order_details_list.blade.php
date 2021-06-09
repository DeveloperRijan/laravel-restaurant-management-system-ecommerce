<?php
  $data = json_decode($order->order_data, true);
?>


@if($order->order_by === "Staff")
  
  <div class="checkout-page">

    <div class="table-responsive">
      <table class="table checkout-tbl text-center">
        <thead>
          <tr>
            <th><small>Product</small></th>
            <th title="Regular Price"><small>Price</small></th>
            <th width="15%"><small>Total</small></th>
          </tr>
        </thead>

        
          <tbody id="checkout-render">
            @foreach($data['checkout_summary']['products'] as $key=>$row)
                <tr>
                  <td>
                    <a href="#">
                    <small>{{$row['product']['title']}}</small>
                    </a>
                  </td>
                  <td>
                    <small>
                      {{env('CURRENCY_SYMBOL').$row['product']['price']}}
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
                  <td class="remove_borders" colspan="2" style="text-align: right;">
                    <small><b>Sub Total</b></small>
                  </td>
                  <td class="remove_borders">
                    {{env('CURRENCY_SYMBOL').$data['checkout_summary']['summary']['sub_total']}}
                  </td>
                </tr>

                <tr class="special_tr d-none">
                  <td class="remove_borders" colspan="2" style="text-align: right;">
                    <small><b>Delivery Charge (+)</b></small>
                  </td>
                  <td class="remove_borders">
                    @if(!is_numeric($data['checkout_summary']['summary']['delivery_charge']['charge_amount']))
                      {{$data['checkout_summary']['summary']['delivery_charge']['charge_amount']}}
                    @else
                      {{env('CURRENCY_SYMBOL').$data['checkout_summary']['summary']['delivery_charge']['charge_amount']}}
                    @endif
                  </td>
                </tr>

                
                <tr class="special_tr">
                  <td class="remove_borders" colspan="2" style="text-align: right;">
                    <small><b>Coupon Applied (-)</b></small>
                  </td>
                  <td class="remove_borders text-center">
                    @if(isset($data['checkout_summary']['couponAppliedResponse']['is_applied']) && $data['checkout_summary']['couponAppliedResponse']['is_applied'] === true)
                    <small class="text-success">{{$data['checkout_summary']['couponAppliedResponse']['msg']}}</small><br>
                    <small>{{env("CURRENCY_SYMBOL").$data['checkout_summary']['couponAppliedResponse']['coupon_discount_amount']}}</small>
                    @else
                    <small class="text-info">No</small>
                    @endif
                  </td>
                </tr>

                <tr class="special_tr">
                  <td class="remove_borders" colspan="2" style="text-align: right;">
                    <small><b>Grand Total</b></small>
                  </td>
                  <td class="remove_borders">
                    <b>{{env('CURRENCY_SYMBOL').$data['checkout_summary']['summary']['grand_total']}}</b>
                  </td>
                </tr>

                <tr class="special_tr">
                  <td class="remove_borders" colspan="3" style="text-align: center;">
                    <small><i class="fa fa-info-circle"></i> Grand Total = (SubTotal - Coupon Discount)</small>
                  </td>
                </tr>

              </tbody>
         

      </table>
    </div>

    <div class="d-flex justify-content-center action-buttons-group">
      @if($order->status === "New")
        <a onclick="return confirm('Are you sure to Move to In Progress')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('In Progress')])}}" class="btn btn-secondary btn-sm mr-1" title="Move to In Progress">In Progress</a>
        <a onclick="return confirm('Are you sure to Move to Out For Delivery')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('Out For Delivery')])}}" class="btn btn-info btn-sm mr-1" title="Move to Out For Delivery">Out For Delivery</a>
        <a onclick="return confirm('Are you sure to Move to Completed')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('Completed')])}}" class="btn btn-success btn-sm mr-1" title="Move to Completed">Completed</a>
        <a onclick="return confirm('Are you sure to Cancel')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('Cancelled')])}}" class="btn btn-danger btn-sm" title="Cancel this order">Cancel</a>
      @endif

      @if($order->status === "In Progress")
        <a onclick="return confirm('Are you sure to Move to Out For Delivery')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('Out For Delivery')])}}" class="btn btn-info btn-sm mr-1" title="Move to Out For Delivery">Out For Delivery</a>
        <a onclick="return confirm('Are you sure to Move to Completed')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('Completed')])}}" class="btn btn-success btn-sm mr-1" title="Move to Completed">Completed</a>
        <a onclick="return confirm('Are you sure to Cancel')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('Cancelled')])}}" class="btn btn-danger btn-sm" title="Cancel this order">Cancel</a>
      @endif

      @if($order->status === "Out For Delivery")
        <a onclick="return confirm('Are you sure to Move to Completed')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('Completed')])}}" class="btn btn-success btn-sm mr-1" title="Move to Completed">Completed</a>
        <a onclick="return confirm('Are you sure to Cancel')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('Cancelled')])}}" class="btn btn-danger btn-sm" title="Cancel this order">Cancel</a>
      @endif
    </div>

  </div>

@else
  <div class="checkout-page">

    <div class="table-responsive">
      <table class="table checkout-tbl text-center">
        <thead>
          <tr>
            <th width="5%">SN.</th>
            <th>Product</th>
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
                    <a href="#">
                    <small>{{$row['product']['title']}}</small>
                    </a>
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
                  <td class="remove_borders" colspan="5" style="text-align: right;">
                    <small><b>Sub Total</b></small>
                  </td>
                  <td class="remove_borders">
                    <small>{{env('CURRENCY_SYMBOL').$data['summary']['sub_total']}}</small>
                  </td>
                </tr>

                <tr class="special_tr">
                  <td class="remove_borders" colspan="5" style="text-align: right;">
                    <small><b>Delivery Charge (+)</b></small>
                  </td>
                  <td class="remove_borders">
                    @if(!is_numeric($data['summary']['delivery_charge']['charge_amount']))
                      <small>{{$data['summary']['delivery_charge']['charge_amount']}}</small>
                    @else
                      <small>{{env('CURRENCY_SYMBOL').$data['summary']['delivery_charge']['charge_amount']}}</small>
                    @endif
                  </td>
                </tr>

                
                <tr class="special_tr">
                  <td class="remove_borders" colspan="5" style="text-align: right;">
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
                  <td class="remove_borders" colspan="5" style="text-align: right;">
                    <small><b>Grand Total</b></small>
                  </td>
                  <td class="remove_borders">
                    <small><b>{{env('CURRENCY_SYMBOL').$data['summary']['grand_total']}}</b></small>
                  </td>
                </tr>

                <tr class="special_tr">
                  <td class="remove_borders" colspan="7" style="text-align: center;">
                    <small><i class="fa fa-info-circle"></i> Grand Total = ((Sub-total + Delivery Charge) - Coupon Discount)</small>
                  </td>
                </tr>

              </tbody>
         

      </table>
    </div>

    <div class="d-flex justify-content-center action-buttons-group">
      @if($order->status === "New")
        <a onclick="return confirm('Are you sure to Move to In Progress')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('In Progress')])}}" class="btn btn-secondary btn-sm mr-1" title="Move to In Progress">In Progress</a>
        <a onclick="return confirm('Are you sure to Move to Out For Delivery')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('Out For Delivery')])}}" class="btn btn-info btn-sm mr-1" title="Move to Out For Delivery">Out For Delivery</a>
        <a onclick="return confirm('Are you sure to Move to Completed')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('Completed')])}}" class="btn btn-success btn-sm mr-1" title="Move to Completed">Completed</a>
        <a onclick="return confirm('Are you sure to Cancel')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('Cancelled')])}}" class="btn btn-danger btn-sm" title="Cancel this order">Cancel</a>
      @endif

      @if($order->status === "In Progress")
        <a onclick="return confirm('Are you sure to Move to Out For Delivery')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('Out For Delivery')])}}" class="btn btn-info btn-sm mr-1" title="Move to Out For Delivery">Out For Delivery</a>
        <a onclick="return confirm('Are you sure to Move to Completed')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('Completed')])}}" class="btn btn-success btn-sm mr-1" title="Move to Completed">Completed</a>
        <a onclick="return confirm('Are you sure to Cancel')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('Cancelled')])}}" class="btn btn-danger btn-sm" title="Cancel this order">Cancel</a>
      @endif

      @if($order->status === "Out For Delivery")
        <a onclick="return confirm('Are you sure to Move to Completed')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('Completed')])}}" class="btn btn-success btn-sm mr-1" title="Move to Completed">Completed</a>
        <a onclick="return confirm('Are you sure to Cancel')" href="{{route('ks.order.actions', [encrypt($order->id), encrypt('Cancelled')])}}" class="btn btn-danger btn-sm" title="Cancel this order">Cancel</a>
      @endif
    </div>
    
  </div>
@endif