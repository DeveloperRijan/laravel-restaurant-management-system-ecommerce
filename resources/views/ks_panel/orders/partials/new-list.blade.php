@if(isset($orders))
  @foreach($orders as $key=>$order)
    <tr role="row">

      <td>
        <div class="text-left parent--heading"><small><b>{{$order->order_by}}</b></small></div>

        <div class="short-info">
          <div>
            <small>{{$order->get_customer->name.", ".$order->get_customer->phone}}</small><br>
            <small>{{$order->get_customer->email}}</small><br>
            
            <small>#{{$order->order_id}}</small> |
            <small>{{date(env("GENERAL_DATE_FORMAT_HI"), strtotime($order->created_at))}}</small> |
            <small>Payment Type : </b> {{$order->payment_type}}</small>
          </div>
          @include("ks_panel.orders.partials.shipping_address_list")
        </div>

        <div class="order-details">
          <h6 class="sub--heading">Order Details</h6>
          @include("ks_panel.orders.partials.order_details_list")
        </div>
      </td>
      
    </tr>
  @endforeach
  <tr>
    <td>
      {!! $orders->links('pagination::bootstrap-4') !!}
    </td>
  </tr>
@endif