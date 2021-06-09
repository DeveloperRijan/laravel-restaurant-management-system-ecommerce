<div class="col-lg-12 col-md-12">
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
          @include("frontendViews.checkout.partials.checkout_data")
        </tbody>
       

    </table>
  </div>

  @if (Auth::check() && \App\Models\Cart::where('user_id', Auth::user()->id)->exists()) 
  <div class="row">
    <div class="col-lg-3 col-md-12"></div>
    <div class="col-lg-6 col-md-12">
      <a class="proceed_next_link" href="{{route('checkout.init')}}?step=address">Proceed to Next <i class="fas fa-arrow-circle-right"></i> </a>
    </div>
    <div class="col-lg-3 col-md-12"></div>
  </div>
  @endif
</div>