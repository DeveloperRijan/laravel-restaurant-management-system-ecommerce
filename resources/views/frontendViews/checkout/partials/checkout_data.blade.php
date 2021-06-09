
@if(Auth::check())
  @if(isset($data['products']) && count($data['products']) > 0)
  
      @foreach($data['products'] as $key=>$row)
      <tr>
        <td>
          <small>
            <button cartid="{{ $row['cart']['id'] }}" type="button" class="btn btn-warning btn-sm removeCartItem"><i class="fas fa-times"></i></button>
          </small>
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
            <button cartid="{{ $row['cart']['id'] }}" class="btnDecreaseQTY">–</button>
            <div>{{ $row['cart']['qty'] }}</div>
            <button cartid="{{ $row['cart']['id'] }}" class="btnIncreaseQTY">+</button>
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
          <small><b>Coupon Code (-)</b></small>
        </td>
        <td class="remove_borders">
          <div>
            @if(isset($data['couponAppliedResponse']['msg']))
              <small class="text-info">{{$data['couponAppliedResponse']['msg']}}</small>
            @endif
          </div>

          @if(isset($data['couponAppliedResponse']['is_applied']) && $data['couponAppliedResponse']['is_applied'] === true)
          <input class="coupon_code_input" readonly="1" type="text" value="{{$data['couponAppliedResponse']['requested_coupon_code']}}">
          <input class="coupon_code_input" type="hidden" name="coupon_code" value="remove">
          @else
          <input class="coupon_code_input" type="text" name="coupon_code" placeholder="Enter Coupon Code" value="@if(isset($data['couponAppliedResponse']['requested_coupon_code'])){{$data['couponAppliedResponse']['requested_coupon_code']}}@endif">
          @endif

          @if(isset($data['couponAppliedResponse']['is_applied']) && $data['couponAppliedResponse']['is_applied'] === true)
          <button class="button" id="apply_coupon_code_btn">Remove</button>
          @else
          <button class="button" id="apply_coupon_code_btn">Apply</button>
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

    @else
      <tr>
        <td colspan="7">
          No Data Available
        </td>
      </tr>
  @endif

@else
  
  <tr>
    <td colspan="7">
      Your cart is empty!
    </td>
  </tr>
@endif