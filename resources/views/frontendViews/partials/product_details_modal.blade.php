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
          <form method="POST" action="{{route('orderNow.item')}}">
            @csrf
            <div class="row">

                <!-- intro content -->
                <div class="col-md-12 col-sm-12">
                    <div class="d-flex justify-content-center title-box">
                      <h5 class="title">{{$productDetailsData->title}}</h5>
                    </div>
                      <?php
                        $priceRegular = $productDetailsData->price;
                        $selling_price = $productDetailsData->price;
                        $discountPercent = $productDetailsData->price;
                        if($productDetailsData->discount_price > 0) {
                         $discountPercent = number_format((($productDetailsData->price / 100) * $productDetailsData->discount_price), 2, '.', '');
                         $selling_price = number_format(($productDetailsData->price - $productDetailsData->discount_price), 2, '.', '');
                        }else{
                          $selling_price = $productDetailsData->price;
                        }
                      ?>
                      <input type="hidden" name="selling_price" value="{{$selling_price}}">
                      @if($productDetailsData->type === "Main")
                        <div class="pricing-info-box">
                          @if($productDetailsData->discount_price > 0)
                          <p  class="reserve-description" style="display: block;">
                            <span>{{env("CURRENCY_SYMBOL")}}</span>{{$priceRegular}} <small>(Regular Price)</small>
                          </p>

                          <p class="reserve-description" style="display: block;">
                            Discount :  - {{env("CURRENCY_SYMBOL").$productDetailsData->discount_price}} / ({{$discountPercent}}%)
                          </p>
                          
                          <p class="reserve-description" style="display: block;">
                            <b>Price</b> : <span style="color: forestgreen">{{env("CURRENCY_SYMBOL").($selling_price)}}</span> | <small>{{ucwords($productDetailsData->size)}}</small> | <small class="stock_status">{{$productDetailsData->stock_status}}</small>
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
                            <b>Price</b> : <span style="color: forestgreen">{{env("CURRENCY_SYMBOL").$selling_price}}</span> | <small>{{ucwords($productDetailsData->size)}}</small> | <small class="stock_status">{{$productDetailsData->stock_status}}</small>
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

                <!-- descriptions -->
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <section class="light-bg booking-details_wrap">
                     <div class="container">
                        <div class="row">

                          @if($productDetailsData->field_names != null && $productDetailsData->field_values != NULL)
                            <div class="col-lg-8 col-md-8 responsive-wrap">
                                <div class="booking-checkbox_wrap">
                                   <div class="booking-checkbox">
                                      {!! nl2br(e($productDetailsData->description)) !!}
                                   </div>
                                </div>
                             </div>
                             <div class="col-lg-4 col-md-4 responsive-wrap">
                                <div class="booking-checkbox_wrap">
                                   <div class="booking-checkbox">
                                      <table class="table tbl-spec">
                                        <?php
                                            $field_names = json_decode($productDetailsData->field_names);
                                            $field_values = json_decode($productDetailsData->field_values);
                                            foreach ($field_names as $key => $name) {
                                                echo "<tr>";
                                                  echo "<td>".$name."</td>";
                                                  echo "<td>:</td>";
                                                  echo "<td class='text-end'>".$field_values[$key]."</td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                      </table>
                                   </div>
                                </div>
                             </div>
                          @else
                            <div class="col-md-12 responsive-wrap">
                                <div class="booking-checkbox_wrap">

                                   <div class="booking-checkbox">
                                      {!! nl2br(e($productDetailsData->description)) !!}
                                      <hr>
                                   </div>
                                </div>
                             </div>
                          @endif


                          @if($productDetailsData->options != '')
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            @include("frontendViews.partials.product_options")
                          </div>
                          @endif

                        </div>
                     </div>
                  </section>
                </div>

                <!-- order action button -->
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
                          <div class="d-flex justify-content-between order-btn-wrapper">
                            <div class="qty-control">
                              <div class="d-flex justify-content-center">
                                <div>
                                  <button class="increase" type="button">
                                    <i class="fas fa-plus"></i>
                                  </button>
                                </div>
                                <div class="qty-val">1</div>
                                <input type="hidden" name="qty" value="1">
                                <div>
                                  <button class="decrease" type="button">
                                    <i class="fas fa-minus"></i>
                                  </button>
                                </div>
                              </div>
                            </div>

                            <div class="order-link">
                              <button type="submit" class="btn @if(!Auth::check()) _showLoginModal  @endif order-now-link" style="width: 100%;cursor: pointer;">Add <b><span class="qty-val">1</span></b> to order 
                                <span style="float: right; padding-right: 5px;"><span>{{env('CURRENCY_SYMBOL')}}</span><span class="inner-selling-price">{{$selling_price}}</span></span>
                              </button>
                            </div>
                          </div>
                        @else
                          <a href="{{route('staff.order.page')}}?product_id={{encrypt($productDetailsData->id)}}" class="btn @if(!Auth::check()) _showLoginModal @endif " style="width: 100%;cursor: pointer;">ORDER NOW</a>
                        @endif
                     </div>
                  </div>
               </div>

               <input type="hidden" name="product_id" value="{{encrypt($productDetailsData->id)}}">
            </div> <!-- .row end here -->
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
@endif