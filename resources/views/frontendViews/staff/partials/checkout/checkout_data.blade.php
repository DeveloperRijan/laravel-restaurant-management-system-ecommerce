
  @if(isset($data['products']) && count($data['products']) > 0)
  
      @foreach($data['products'] as $key=>$row)
      <tr>
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
        <td class="remove_borders" colspan="3" style="text-align: right;">
          <small><b>Sub Total</b></small>
        </td>
        <td class="remove_borders">
          {{env('CURRENCY_SYMBOL').$data['summary']['sub_total']}}
        </td>
      </tr>

      <tr class="special_tr" style="display: none;">
        <td class="remove_borders" colspan="3" style="text-align: right;">
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


    @if($data['products'][0]['product']['item_type'] === 'Meal')
      <tr class="special_tr">
        <td class="remove_borders" colspan="3" style="text-align: right;">
          <small><b>Coupon (-)</b></small>
        </td>
        <td class="remove_borders">
          <div>
            @if(isset($data['couponAppliedResponse']['msg']))
              <small class="text-info">{{$data['couponAppliedResponse']['msg']}}</small>
            @endif
          </div>

          @if(isset($data['couponAppliedResponse']['is_applied']) && $data['couponAppliedResponse']['is_applied'] === true)
          <button class="button" action='remove' id="apply_coupon_code_btn" type="button">Remove</button>
          @else
          <button class="button" action='use' id="apply_coupon_code_btn" type="button">Use Coupon</button>
          @endif
        </td>
      </tr>
    @endif

      <tr class="special_tr">
        <td class="remove_borders" colspan="3" style="text-align: right;">
          <small><b>Grand Total</b></small>
        </td>
        <td class="remove_borders">
          <b>{{env('CURRENCY_SYMBOL').$data['summary']['grand_total']}}</b>
        </td>
      </tr>

@else
  
  <tr>
    <td colspan="4">
      Please Select Food
    </td>
  </tr>
@endif