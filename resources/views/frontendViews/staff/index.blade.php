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


    <!--  foods section starts -->
    @if(count($categories) > 0)
      @foreach($categories as $key=>$category)
        @if(count($category->get_products) > 0)
          <section id="section--number--{{$key}}">
              <div class="inner_popular container">
                  <h1 class="home_section_headerTxt">{{$category->name}}</h1>
                  @include("frontendViews.staff.partials.item-list", ['products'=>$category->get_products])
              </div>
          </section>
        @endif
      @endforeach
    @endif
    <!-- foods section ends -->



@endsection