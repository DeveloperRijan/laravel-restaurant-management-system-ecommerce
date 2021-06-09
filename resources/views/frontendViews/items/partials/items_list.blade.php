<div class="inner_popular container">
  <div class="row">
    
        @if(!$products->isEmpty())

        @foreach($products as $key=>$product)
         <?php
            $images = json_decode($product->images, true);
            $imgSrc = $publicAssetsPathStart.\Config::get("constants.FILE_PATH.PRODUCT").$images[0];
         ?>
         
           <div class="col-lg-4 col-md-4 col-sm-12">
             <div class="foodBoxWrapper">
                 <div class="food_box">
                     <div class="food_content_box">
                       <h3>{{$product->title}}</h3>
                       <p class="short-des">
                         <?php
                            $limitChars = \Config::get('constants.PRODUCT.DESCRIPTION_LENGTH_SHOW');
                            echo \Str::words($product->description, $limitChars);
                         ?>
                       </p>

                       <div class="pricing">
                           <h4><span>{{env("CURRENCY_SYMBOL")}}</span>{{$product->price}}</h4>
                       </div>
                     </div>
                     <div class="food_img">
                        <img src="{{$imgSrc}}" alt="{{$product->title}}" />
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
