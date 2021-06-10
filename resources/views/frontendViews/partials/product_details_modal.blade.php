@if(isset($productDetailsData))
<div class="modal fade" id="productDetailsModal__" tabindex="-1" aria-labelledby="exampleModalLabelDetailsLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="max-width: 800px">
    <div class="modal-content">
      <div class="modal-body p-0">
        
        <div id="productDetailsCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">

            @foreach(json_decode($productDetailsData->images, true) as $key=>$image)
            <div class="carousel-item @if($key == 0) active @endif">
              <img src="{{$publicAssetsPathStart.\Config::get('constants.FILE_PATH.PRODUCT').$image}}" class="d-block w-100" alt="">
            </div>
            @endforeach

          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#productDetailsCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#productDetailsCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>

        <div class="txt-wrapper">
          
          <div class="row">

         <div class="col-md-12 col-sm-12">
            <div class="d-flex justify-content-center title-box">
              <h5 class="title">{{$productDetailsData->title}}</h5>
            </div>

                @if($productDetailsData->type === "Main")
                  <div class="pricing-info-box">
                    @if($productDetailsData->discount_price > 0)
                    <p  class="reserve-description" style="display: block;">
                      <span>{{env("CURRENCY_SYMBOL")}}</span>{{$productDetailsData->price}} <small>(Regular Price)</small>
                    </p>

                    <p class="reserve-description" style="display: block;">
                      Discount :  - {{env("CURRENCY_SYMBOL").$productDetailsData->discount_price}} / ({{number_format(($productDetailsData->price / 100) * $productDetailsData->discount_price, 1)}}%)
                    </p>
                    
                    <p class="reserve-description" style="display: block;">
                      <b>Price</b> : <span style="color: forestgreen">{{env("CURRENCY_SYMBOL").($productDetailsData->price - $productDetailsData->discount_price)}}</span> | <small>{{ucwords($productDetailsData->size)}}</small> | <small class="stock_status">{{$productDetailsData->stock_status}}</small>
                    </p>

                    @else
                    <p class="reserve-description" style="display: block;">
                      <b>Price</b> : <span style="color: forestgreen">{{env("CURRENCY_SYMBOL").$productDetailsData->price}}</span> | <small>{{ucwords($productDetailsData->size)}}</small> | <small class="stock_status">{{$productDetailsData->stock_status}}</small>
                    </p>
                    @endif
                  </div>

                @else
                  <div class="pricing-info-box">
                    <p class="reserve-description" style="display: block;">
                      <b>Price</b> : <span style="color: forestgreen">{{env("CURRENCY_SYMBOL").$productDetailsData->price}}</span> | <small>{{ucwords($productDetailsData->size)}}</small> | <small class="stock_status">{{$productDetailsData->stock_status}}</small>
                    </p>
                  </div>
                @endif

                <div class="reserve-seat-block">
                   <div class="reserve-btn">
                      <div class="featured-btn-wrap">
                        <button item_id="{{encrypt($productDetailsData->id)}}" title="I love this item" class="@if(Auth::check()) loveThisItem @else _showLoginModal @endif btn-pg like-it"> {{$productDetailsData->feedbackFormat($productDetailsData->total_feedback)}} <span class="fas fa-heart"></span></button>
                      </div>
                   </div>
                </div>


                @if($productDetailsData->note != '')
                  <div class="pricing-info-box">
                    <p class="reserve-description" style="display: block;">
                      <small><i class="fas fa-info-circle"></i> {!! nl2br(e($productDetailsData->note)) !!}</small>
                    </p>
                  </div>
                @endif
             </div>


             <div class="col-md-12 responsive-wrap" style="margin-top: 50px">
                <div class="delivery-info">

                  @if($productDetailsData->type === "Main")
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
                      @if($productDetailsData->type === "Main")
                        <a href="{{route('orderNow.item', encrypt($productDetailsData->id))}}" class="btn @if(!Auth::check()) _showLoginModal  @endif order-now-link" style="width: 100%;cursor: pointer;">ORDER NOW</a>
                      @else
                        <a href="{{route('staff.order.page')}}?product_id={{encrypt($productDetailsData->id)}}" class="btn order-now-link" style="width: 100%;cursor: pointer;">ORDER NOW</a>
                      @endif
                   </div>
                </div>
             </div>
             
          </div>

        </div>

      </div>
    </div>
  </div>
</div>
@endif