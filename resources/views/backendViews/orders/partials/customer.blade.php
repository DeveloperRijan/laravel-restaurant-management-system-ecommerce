<div class="table-responsive">
  <table class="table dataTable" width="100%" style="width: 100%;">
   
   <tbody>
    
    <tr>
      <th>Customer</th>
      <td>{{$order->get_customer->name}}</td>
    </tr>

    <tr>
      <th>Customer Email</th>
      <td>{{$order->get_customer->email}}</td>
    </tr>

    <tr>
      <th>Customer Phone</th>
      <td>{{$order->get_customer->phone}}</td>
    </tr>
     
   </tbody>
  </table>
</div>