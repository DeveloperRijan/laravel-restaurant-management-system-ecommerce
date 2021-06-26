<div class="container" id="home--hero--banner">
  <div class="hero_area container">
      <h1 style="color: {{$home_banner_title_color}}">{{$home_banner_title}}</h1>
      <p style="color: {{$home_banner_description_color}}">{{$home_banner_description}}</p>
      <div class="search_field">
          <form class="top-search-form" action="{{route('postcode.detectCollectionOrDelivery')}}" method="POST">
            @csrf
              <input name="post_code" type="text" placeholder="{{$search_box_text}}" style="background-color: {{$search_box_bg_color}}" />
              <select>
                <option value="delivery">&#xf017; Delivery Now</option>
                <option value="schedule">&#xf133; Schedule</option>
              </select>
              <button type="submit" style="color: {{$search_button_text_color}};background:{{$search_button_bg_color}}"><span class="top-search-btn-txt">{{$search_button_text}}</span></button>
          </form>
      </div>

      <div class="delivery_graph">
          <img src="{{$publicAssetsPathStart}}frontend/images/steps.png">
      </div>
  </div>
</div>