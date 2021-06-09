@extends("frontendViews.layouts.master")

@section("content")

      <section class="slider d-flex align-items-center">
         <div class="container">
            <div class="row d-flex justify-content-center">
               <div class="col-md-12">
                  <div class="slider-title_box">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="slider-content_wrap">
                              <h1>Are you hungry?</h1>
                              <h5>We are here ! Let's find out some special foods quick now...</h5>
                           </div>
                        </div>
                     </div>
                     <div class="row d-flex justify-content-center">
                        <div class="col-md-10">
                           <form class="form-wrap mt-4">
                              <div class="btn-group" role="group" aria-label="Basic example">
                                 <input type="text" placeholder="What are your looking for?" class="btn-group1">
                                 <button type="submit" class="btn-form"><span class="icon-magnifier search-icon"></span>SEARCH<i class="pe-7s-angle-right"></i></button>
                              </div>
                           </form>
                           <div class="slider-link"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>




      <section class="main-block main-menu-block">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-md-5">
                  <div class="styled-heading">
                     <h3>Our Menu List</h3>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-3 category-responsive">
                  <a href="{{route('item.list.page')}}?menu=SeaFood" class="category-wrap">
                     <div class="category-block">
                        <div class="category-img">
                           <img src="{{$publicAssetsPathStart}}frontend/images/default_menu_icons/sea_food.png">
                        </div>
                        <h6>SeaFood</h6>
                     </div>
                  </a>
               </div>
               <div class="col-md-3 category-responsive">
                  <a href="{{route('item.list.page')}}?menu=Chefs-Special" class="category-wrap">
                     <div class="category-block">
                        <div class="category-img">
                           <img src="{{$publicAssetsPathStart}}frontend/images/default_menu_icons/chefs.png">
                        </div>
                        <h6>Chef's Special</h6>
                     </div>
                  </a>
               </div>
               <div class="col-md-3 category-responsive">
                  <a href="{{route('item.list.page')}}?menu=corn-soup" class="category-wrap">
                     <div class="category-block">
                        <div class="category-img">
                           <img src="{{$publicAssetsPathStart}}frontend/images/default_menu_icons/corn.png">
                        </div>
                        <h6>Corn Soup</h6>
                     </div>
                  </a>
               </div>
               <div class="col-md-3 category-responsive">
                  <a href="{{route('item.list.page')}}?menu=dinner" class="category-wrap">
                     <div class="category-block">
                        <div class="category-img">
                           <img src="{{$publicAssetsPathStart}}frontend/images/default_menu_icons/dinner.png">
                        </div>
                        <h6>Dinner</h6>
                     </div>
                  </a>
               </div>
               <div class="col-md-3 category-responsive">
                  <a href="{{route('item.list.page')}}?menu=lunch" class="category-wrap">
                     <div class="category-block">
                        <div class="category-img">
                           <img src="{{$publicAssetsPathStart}}frontend/images/default_menu_icons/dinner-table.png">
                        </div>
                        <h6>Lunch</h6>
                     </div>
                  </a>
               </div>
               <div class="col-md-3 category-responsive">
                  <a href="{{route('item.list.page')}}?menu=coffee" class="category-wrap">
                     <div class="category-block">
                        <div class="category-img">
                           <img src="{{$publicAssetsPathStart}}frontend/images/default_menu_icons/hot-cup.png">
                        </div>
                        <h6>Coffee</h6>
                     </div>
                  </a>
               </div>
               <div class="col-md-3 category-responsive">
                  <a href="{{route('item.list.page')}}?menu=snakes-soups" class="category-wrap">
                     <div class="category-block">
                        <div class="category-img">
                           <img src="{{$publicAssetsPathStart}}frontend/images/default_menu_icons/snakes.png">
                        </div>
                        <h6>Snakes & Soups</h6>
                     </div>
                  </a>
               </div>
               <div class="col-md-3 category-responsive">
                  <a href="{{route('item.list.page')}}?menu=drinks" class="category-wrap">
                     <div class="category-block">
                        <div class="category-img">
                           <img src="{{$publicAssetsPathStart}}frontend/images/default_menu_icons/liquor.png">
                        </div>
                        <h6>Drinks</h6>
                     </div>
                  </a>
               </div>

               

               <div class="col-md-3 category-responsive">
                  <a href="{{route('item.list.page')}}?menu=SeaFood" class="category-wrap">
                     <div class="category-block">
                        <div class="category-img">
                           <img src="{{$publicAssetsPathStart}}frontend/images/default_menu_icons/sea_food.png">
                        </div>
                        <h6>SeaFood</h6>
                     </div>
                  </a>
               </div>
               <div class="col-md-3 category-responsive">
                  <a href="{{route('item.list.page')}}?menu=Chefs-Special" class="category-wrap">
                     <div class="category-block">
                        <div class="category-img">
                           <img src="{{$publicAssetsPathStart}}frontend/images/default_menu_icons/chefs.png">
                        </div>
                        <h6>Chef's Special</h6>
                     </div>
                  </a>
               </div>
               <div class="col-md-3 category-responsive">
                  <a href="{{route('item.list.page')}}?menu=corn-soup" class="category-wrap">
                     <div class="category-block">
                        <div class="category-img">
                           <img src="{{$publicAssetsPathStart}}frontend/images/default_menu_icons/corn.png">
                        </div>
                        <h6>Corn Soup</h6>
                     </div>
                  </a>
               </div>
               <div class="col-md-3 category-responsive">
                  <a href="{{route('item.list.page')}}?menu=dinner" class="category-wrap">
                     <div class="category-block">
                        <div class="category-img">
                           <img src="{{$publicAssetsPathStart}}frontend/images/default_menu_icons/dinner.png">
                        </div>
                        <h6>Dinner</h6>
                     </div>
                  </a>
               </div>
               <div class="col-md-3 category-responsive">
                  <a href="{{route('item.list.page')}}?menu=lunch" class="category-wrap">
                     <div class="category-block">
                        <div class="category-img">
                           <img src="{{$publicAssetsPathStart}}frontend/images/default_menu_icons/dinner-table.png">
                        </div>
                        <h6>Lunch</h6>
                     </div>
                  </a>
               </div>
               <div class="col-md-3 category-responsive">
                  <a href="{{route('item.list.page')}}?menu=coffee" class="category-wrap">
                     <div class="category-block">
                        <div class="category-img">
                           <img src="{{$publicAssetsPathStart}}frontend/images/default_menu_icons/hot-cup.png">
                        </div>
                        <h6>Coffee</h6>
                     </div>
                  </a>
               </div>
               <div class="col-md-3 category-responsive">
                  <a href="{{route('item.list.page')}}?menu=snakes-soups" class="category-wrap">
                     <div class="category-block">
                        <div class="category-img">
                           <img src="{{$publicAssetsPathStart}}frontend/images/default_menu_icons/snakes.png">
                        </div>
                        <h6>Snakes & Soups</h6>
                     </div>
                  </a>
               </div>
               <div class="col-md-3 category-responsive">
                  <a href="{{route('item.list.page')}}?menu=drinks" class="category-wrap">
                     <div class="category-block">
                        <div class="category-img">
                           <img src="{{$publicAssetsPathStart}}frontend/images/default_menu_icons/liquor.png">
                        </div>
                        <h6>Drinks</h6>
                     </div>
                  </a>
               </div>
               
            </div>
         </div>
      </section>


@endsection