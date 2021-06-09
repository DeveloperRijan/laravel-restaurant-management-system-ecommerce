<div class="inner_popular container">
  <div class="row">
    
        @if(!$products->isEmpty())

        @foreach($products as $key=>$product)
         <?php
            $images = json_decode($product->images, true);
            $imgSrc = $publicAssetsPathStart.\Config::get("constants.FILE_PATH.PRODUCT").$images[0];
         ?>
         <div class="col-lg-4 col-md-6 col-sm-6">
           <div class="foodBoxWrapper">
               <div class="food_box">
                   <div class="food_img">
                       <a href="{{route('item.details.page', $product->slug)}}">
                          <img src="{{$imgSrc}}" alt="{{$product->title}}" />
                       </a>
                   </div>

                   <h3><a href="{{route('item.details.page', $product->slug)}}">{{$product->title}}</a></h3>
                   <p><small>{{$product->get_category->name}}</small> | <small>{{$product->item_type}}</small> | <small class="stock_status">{{$product->stock_status}}</small></p>

                   <div class="pricing">
                       <h4><span>{{env("CURRENCY_SYMBOL")}}</span>{{$product->price}}</h4>
                       <a href="{{route('staff.order.page')}}?product_id={{encrypt($product->id)}}"  >Order Now</a>
                   </div>
               </div>

               <div class="restaurant">
                   <div class="love_react 
                      @if(Auth::check()) loveThisItem @else _showLoginModal @endif w-100" item_id="{{encrypt($product->id)}}">
                       <div><i class="far fa-heart"></i></div>
                       <p>{{$product->feedbackFormat($product->total_feedback)}}</p>
                   </div>
               </div>
           </div>
         </div>
        @endforeach

      @else
      <p class="text-danger text-center">No Items Found</p>
      @endif
    
  </div>

</div>


<div>
  @include("pagination.custom", ['paginateAbleCollection'=>$products])
</div>
