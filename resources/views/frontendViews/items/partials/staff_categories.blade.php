@push("styles")
<style type="text/css">
  li.hidden-category{
    display: none;
  }
</style>
@endpush

<div id="tertiary" class="sidebar-container" role="complementary" style="padding: 40px 0">
 <div class="sidebar-inner">
    <div class="widget-area clearfix">
       <div id="azh_widget-11" class="widget widget_azh_widget">
          <div class="widget-title d-flex justify-content-between">
             <div style="color: #fff;font-size: 18px">
                 <i class="fa fa-times"></i>
             </div>
             <div>
                 <h3 style="font-size: 18px">Search Filters</h3>
             </div>
             <div style="color: #fff;font-size: 18px">
                 <i class="fa fa-check"></i>
             </div>
          </div>

          <div class="d-flex justify-content-between" style="border: 1px solid #ededed">
              <input onkeyup="filter_items_now()" class="filter_items" type="text" name="filter_items" placeholder="Search your favorite food...">
              <button type="button"><i class="fa fa-search"></i></button>
          </div>
           <div class="taxonomy-radio product_cat-wrapper" data-taxonomy="product_cat">
              <ul id="render_categoreies">
                @if(!$categories->isEmpty())
                  @foreach($categories as $key=>$category)
                    <li id="listing-{{$key}}"><label for="in-product_cat-{{$key}}"><div class="checkIcon"><i class="fa fa-check"></i></div> {{$category->name}}</label> <input type="radio" id="in-product_cat-{{$key}}" name="product_cat" value="{{$category->id}}"></li>
                  @endforeach
                @else
                  <li>No Item Founds</li>
                @endif
              </ul>
           </div>
       </div>

      {{--
       <div class="widget widget_azh_widget">
           <h6 class="sm-title">Popular Categories</h6>
           <div class="tags">
               <label class="tag">Asian <i class="fa fa-times"></i></label>
               <input class="d-none" id="popular_cats_" type="radio" name="popular_cats" value="">
           </div>
       </div>
       --}}

       <div class="widget widget_azh_widget">
           <div class="d-flex justify-content-between">
               <h6 class="sm-title">Price Range</h6>
           </div>
           <div class="rangerSliderBox">
              <div class="d-flex justify-content-between custom-price-range ">
                  <div>
                      <div class="rangeValueBlock">
                          $<span id="range-startAmount"></span>
                      </div>
                  </div>
                  <div id="slider-range"></div>
                  <div>
                      <div class="rangeValueBlock">
                          $<span id="range-endAmount"></span>
                      </div>
                  </div>
              </div>
              <input type="hidden" name="hidden_slide_range_start_value" value="">
              <input type="hidden" name="hidden_slide_range_end_value" value="">
           </div>
       </div>
    </div>
    <!-- .widget-area -->
 </div>
 <!-- .sidebar-inner -->
</div>


@push("scripts")
  <script type="text/javascript">
    var slide_range_start_val  = Number("{{$products->min('price')}}");
    var slide_range_end_val  = Number("{{$products->max('price')}}");

    $( function() {
        $( "#slider-range" ).slider({
          range: true,
          min: slide_range_start_val,
          max: slide_range_end_val,
          values: [ slide_range_start_val, slide_range_end_val ],
          slide: function( event, ui ) {
            slide_range_start_val = ui.values[0];
            slide_range_end_val = ui.values[1];

            $(".custom-price-range #range-startAmount").html(slide_range_start_val)
            $(".custom-price-range #range-endAmount").html(slide_range_end_val)
            
            //set input values as well
            $(".rangerSliderBox input[name='hidden_slide_range_start_value']").val(slide_range_start_val)
            $(".rangerSliderBox input[name='hidden_slide_range_end_value']").val(slide_range_end_val)
            filter_items_now()
          }
        });

        $( "#range-startAmount" ).html( $( "#slider-range" ).slider( "values", 0 ))
        $( "#range-endAmount" ).html( $( "#slider-range" ).slider( "values", 1 ))
    });
  </script>

  <script type="text/javascript">
      $("#sidebar-section div.taxonomy-radio ul li input[type='radio']").on("click", function(){
         
          $("#sidebar-section div.taxonomy-radio ul li div.checkIcon").removeClass('checkedStatus')

          let parentID = $(this).parent("li").attr('id')
         $("li#"+parentID+" label div").addClass('checkedStatus')

         filter_items_now()
      })
  </script>



<script type="text/javascript">
  var topFormSearchQuery = "{{Request::get("search")}}"

  function filter_items_now(){
    let searchKey =$("input[name='filter_items']").val()

    let min_price = $(".rangerSliderBox input[name='hidden_slide_range_start_value']").val()
    let max_price = $(".rangerSliderBox input[name='hidden_slide_range_end_value']").val()
    let category = null;
    let sortByPopular = "No";

    $("#sidebar-section div.taxonomy-radio ul li input[type='radio']").each(function(){
        if ($(this).prop("checked") === true) {
          category = $(this).val()
        }
    })

    if ($("input[name='sort_by_popular_items']").val() === 'Yes') {
      sortByPopular = "Yes"
    }
    
    
    console.log("/filter_staff_items?q="+searchKey+"&min_price="+min_price+"&max_price="+max_price+"&category="+category+"&sort_by_popular="+sortByPopular+"&topFormSearchQuery="+topFormSearchQuery)
      
      $.ajax({
        url: "/filter_staff_items?q="+searchKey+"&min_price="+min_price+"&max_price="+max_price+"&category="+category+"&sort_by_popular="+sortByPopular+"&topFormSearchQuery="+topFormSearchQuery,
        method: "GET",
        dataType: 'HTML',
        cache: false,
        success: function(response){
          $("div#render__filtered_items").html(response)
        },
        error: function (jqXHR, textStatus, errorThrown) {

          let string_to_obj = JSON.parse(jqXHR.responseText)

          if (jqXHR.status === 422) {
            alert(string_to_obj.msg)
          }else{
            console.log("Something went wrong")
          }

          }
      });
  }
</script>
@endpush