@foreach($products as $key=>$product)
   <?php
      $images = json_decode($product->images, true);
      $imgSrc = $publicAssetsPathStart.\Config::get("constants.FILE_PATH.PRODUCT").$images[0];
   ?>
   <div class="foodBoxWrapper">
       <div class="food_box">
           <div class="food_img">
               <a href="{{route('item.details.page', $product->slug)}}">
                  <img src="{{$imgSrc}}" alt="{{$product->title}}" />
               </a>
           </div>

           <h3><a href="{{route('item.details.page', $product->slug)}}">{{$product->title}}</a></h3>
           <p>{{$product->get_category->name}} | {{$product->item_type}}</p>

           <div class="pricing">
               <h4><span>{{env("CURRENCY_SYMBOL")}}</span>{{$product->price}}</h4>
               <a href="{{route('staff.order.page')}}?product_id={{encrypt($product->id)}}" class=""  >Order Now</a>
           </div>
       </div>

   </div>
@endforeach
