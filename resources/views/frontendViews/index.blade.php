@extends("frontendViews.layouts.master")

@section("content")
    
    @if(count($categories) > 0)
    <div class="nav-categories">
      <ul class="nav justify-content-center">
        @foreach($categories as $key=>$category)
          @if(count($category->get_products) > 0)
          <li class="nav-item">
            <a class="nav-link active nav-to-scroll-section" aria-current="page" href="" target-section="section--number--{{$key}}">{{$category->name}}</a>
          </li>
          @endif
        @endforeach
      </ul>
    </div>
    @endif


  @if(count($categories) > 0)
    @if(count($category->get_products) > 0)
      <!--  foods section starts -->
      <section id="section--number--0">
          <div class="inner_popular container">
            <h1 class = "home_section_headerTxt">{{$categories[0]->name}}</h1>
            <div class="row">
                @include("frontendViews.partials.item-list", ['products'=>$categories[0]['get_products']])
            </div>
          </div>
      </section>
      <!-- foods section ends -->
      @endif
  @endif

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


  @if(count($categories) > 1)
    <!--  foods section starts -->
    @foreach($categories as $key=>$category)
      @if($key != 0 && count($category->get_products) > 0)
      <section id="section--number--{{$key}}">
          <div class="inner_popular container">
              <h1 class = "home_section_headerTxt">{{$category->name}}</h1>
              <div class="row">
                @include("frontendViews.partials.item-list", ['products'=>$category->get_products])
              </div>
          </div>
      </section>
      @endif
    @endforeach
    <!-- foods section ends -->
  @endif

@endsection