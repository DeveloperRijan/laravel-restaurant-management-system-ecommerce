@extends("frontendViews.layouts.master")

@section("content")

    <!--  foods section starts -->
    <section id="popular_foods">
        <div class="inner_popular container">
          <h1 class = "home_section_headerTxt">Offers/Meals Of The Day </h1>
          <div class="row">
            @if($homeContentRow1 !== NULL && count($homeContentRow1) > 0)
              @include("frontendViews.partials.item-list", ['products'=>$homeContentRow1])
            @endif
          </div>
        </div>
    </section>
    <!-- foods section ends -->

  @if($frontendUIData)
    <div data-section="ordering-steps" class="section dark" style="background-image: url('{{$publicAssetsPathStart}}frontend/images/dark-pattern-2-steps.jpg')">
       <h2 class="title">Easy 2 Step Order</h2>
       <img src="{{$publicAssetsPathStart}}frontend/images/leaves.png" alt="leaves" class="leaves"><img src="{{$publicAssetsPathStart}}frontend/images/nuts.png" alt="nuts" class="nuts">
       <div class="container">
          <div class="order-step-wrapper row">
             <div class="arrow solid" style="display: none;background-image: url('{{$publicAssetsPathStart}}frontend/images/solid-arrow.png')"></div>
             <div class="arrow dotted" style="background-image: url('{{$publicAssetsPathStart}}frontend/images/dotted-arrow.png')"></div>
             <div class="order-step-inner">
                <div class="row">
                    <div class="col-sm-6 order-step">
                       <div class="order-step-border">
                          <div class="order-step-number">1</div>
                          <img src="{{$publicAssetsPathStart}}frontend/images/dish.png" alt="dish" class="order-step-icon">
                       </div>
                       <h4 style="color: {{$frontendUIData->easy_2_step_left_title_color}}">{{$frontendUIData->easy_2_step_left_title}}</h4>
                       <p style="color: {{$frontendUIData->easy_2_step_left_description_color}}">{{$frontendUIData->easy_2_step_left_description}}</p>
                    </div>
                    <div class="col-sm-6 order-step">
                       <div class="order-step-border">
                          <div class="order-step-number">2</div>
                          <img src="{{$publicAssetsPathStart}}frontend/images/delivery.png" alt="delivery" class="order-step-icon">
                       </div>
                       <h4 style="color: {{$frontendUIData->easy_2_step_right_title_color}}">{{$frontendUIData->easy_2_step_right_title}}</h4>
                       <p style="color: {{$frontendUIData->easy_2_step_right_description_color}}">{{$frontendUIData->easy_2_step_right_description}}</p>
                    </div>
                </div>
             </div>
          </div>
          <p class="subtitle">{{$frontendUIData->easy_2_step_small_text}}</p>
       </div>
       <div class="city" style="background-image: url('{{$publicAssetsPathStart}}frontend/images/city.png')"></div>
    </div>
  @endif


    <!--  foods section starts -->
    <section id="popular_foods">
        <div class="inner_popular container">
            <h1 class = "home_section_headerTxt">Family Orders </h1>
            <div class="row">
              @if($homeContentRow2 !== NULL && count($homeContentRow2) > 0)
                  @include("frontendViews.partials.item-list", ['products'=>$homeContentRow2])
              @endif
            </div>

        </div>
    </section>
    <!-- foods section ends -->



    @if($homeContentRow3 !== NULL && count($homeContentRow3) > 0)
    <!--  foods section starts -->
    <section id="popular_foods">
        <div class="inner_popular container">
          <h1 class = "home_section_headerTxt">Items of the Day </h1>
            <div class="row">
              @include("frontendViews.partials.item-list", ['products'=>$homeContentRow3])
            </div>
        </div>
    </section>
    <!-- foods section ends -->
    @endif


@endsection