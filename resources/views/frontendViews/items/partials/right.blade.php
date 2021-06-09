<section class="reserve-block">
   <div class="container">
      <div class="row">

         <div class="col-md-12 col-sm-12">
            <div class="d-flex justify-content-center title-box">
              <h5 class="title">{{$product->title}}</h5>
            </div>

            @if($product->type === "Main")
              <div class="pricing-info-box">
                @if($product->discount_price > 0)
                <p  class="reserve-description" style="display: block;">
                  <span>{{env("CURRENCY_SYMBOL")}}</span>{{$product->price}} <small>(Regular Price)</small>
                </p>

                <p class="reserve-description" style="display: block;">
                  Discount :  - {{env("CURRENCY_SYMBOL").$product->discount_price}} / ({{number_format(($product->price / 100) * $product->discount_price, 1)}}%)
                </p>
                
                <p class="reserve-description" style="display: block;">
                  <b>Price</b> : <span style="color: forestgreen">{{env("CURRENCY_SYMBOL").($product->price - $product->discount_price)}}</span> | <small>{{ucwords($product->size)}}</small> | <small class="stock_status">{{$product->stock_status}}</small>
                </p>

                @else
                <p class="reserve-description" style="display: block;">
                  <b>Price</b> : <span style="color: forestgreen">{{env("CURRENCY_SYMBOL").$product->price}}</span> | <small>{{ucwords($product->size)}}</small> | <small class="stock_status">{{$product->stock_status}}</small>
                </p>
                @endif
              </div>

            @else
              <div class="pricing-info-box">
                <p class="reserve-description" style="display: block;">
                  <b>Price</b> : <span style="color: forestgreen">{{env("CURRENCY_SYMBOL").$product->price}}</span> | <small>{{ucwords($product->size)}}</small> | <small class="stock_status">{{$product->stock_status}}</small>
                </p>
              </div>
            @endif


            @if($product->note != '')
              <div class="pricing-info-box">
                <p class="reserve-description" style="display: block;">
                  <small><i class="fas fa-info-circle"></i> {!! nl2br(e($product->note)) !!}</small>
                </p>
              </div>
            @endif
         </div>


         <div class="col-md-12 responsive-wrap" style="margin-top: 50px">
            <div class="delivery-info">

              @if($product->type === "Main")
              <div class="d-flex justify-content-center box">
                  <span class="fas fa-truck"></span>
                  @if($deliverCharge && $deliverCharge->status === "Active")
                    <p style="margin: 0; margin-top: -5px; margin-left: 5px;">Delivery Charge <span style="color: forestgreen">{{env("CURRENCY_SYMBOL").$deliverCharge->charge_amount}}</span><br></p>
                  @else
                    <p style="margin: 0; margin-top: -5px; margin-left: 5px;">Delivery Charge <span style="color: forestgreen">Free</span><br></p>
                  @endif
               </div>
              @endif

               <div class="address" style="padding: 0;padding: 10px;margin-top: 15px;">
                  @if($product->type === "Main")
                    <a href="{{route('orderNow.item', encrypt($product->id))}}" class="btn @if(!Auth::check()) _showLoginModal  @endif order-now-link" style="width: 100%;cursor: pointer;">ORDER NOW</a>
                  @else
                    <a href="{{route('staff.order.page')}}?product_id={{encrypt($product->id)}}" class="btn order-now-link" style="width: 100%;cursor: pointer;">ORDER NOW</a>
                  @endif
               </div>
            </div>
         </div>

         <div class="col-md-12">
            <div class="reserve-seat-block">
               <div class="reserve-btn">
                  <div class="featured-btn-wrap">
                    @if($product->type === "Main")
                        <button item_id="{{encrypt($product->id)}}" title="I love this item" class="@if(Auth::check()) loveThisItem @else _showLoginModal @endif btn-pg like-it"> {{$product->feedbackFormat($product->total_feedback)}} <span class="fas fa-heart"></span></button>
                        <button item_id="{{encrypt($product->id)}}" title="Add to cart" class="ti @if(Auth::check()) addToCart @else _showLoginModal @endif btn-pg add-to-cart"><i class="fas fa-cart-plus"></i></button>
                    @else
                        <button item_id="{{encrypt($product->id)}}" title="I love this item" class="@if(Auth::check()) loveThisItem @else _showLoginModal @endif btn-pg like-it" style="width: 100%"> {{$product->feedbackFormat($product->total_feedback)}} <span class="fas fa-heart"></span></button>
                    @endif
                  </div>
               </div>
            </div>
         </div>

      </div>
   </div>
</section>