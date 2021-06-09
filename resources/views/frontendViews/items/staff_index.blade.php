@extends("frontendViews.layouts.master")

@push("styles")
<style type="text/css">
    /*increase item numbers*/
    .foodBoxWrapper{
        width:31.33%
    }
    span.add_to_cart_txt{
      display: none;
    }
    h6.sortby_popular{
      color: #888; 
      font-size: 14px;
      cursor: pointer;
      cursor: pointer;
    }
</style>
@endpush

@section("content")
    <!-- change address starts -->
    <section style="border-bottom: 1px solid #ddd;margin-bottom: 0px">
        <div class="container">
            <div class="d-flex justify-content-between p-3">
                <h6 style="color: #888; font-size: 14px;">
                  {{$products->total()}} Results so far
                  @if(\Request::get('search') != '')
                    for <b>{{\Request::get('search')}}</b>
                  @endif
                </h6>
                <h6 id="sortByPopularTxt" class="sortby_popular">
                  <label>Sort by popularity</label>
                  <input type="hidden" name="sort_by_popular_items" value="No">
                </h6>
            </div>
        </div>
    </section>
    <!-- change address ends -->

    <div id="sidebar-section" class="container active-sidebar" style="margin-bottom: 150px">
        <div class="row">

            <div class="col-lg-3 col-md-3 col-sm-12">
                @include("frontendViews.items.partials.staff_categories")
            </div>

            <div class="col-lg-9 col-md-9 col-sm-12">
                <!--  foods section starts -->
                <section id="popular_foods popular_foods_items">
                  <div id="render__filtered_items" class="item-list-page">
                    @include("frontendViews.items.partials.staff_items_list",['products'=>$products])
                  </div>
                </section>
                <!-- foods section ends -->
            </div>
        </div>
    </div>


@endsection


@push("scripts")
<script type="text/javascript">
  $("#sortByPopularTxt").on("click", function(){
    let checkVal = $("input[name='sort_by_popular_items']").val()

    if (checkVal === "Yes") {
      $("input[name='sort_by_popular_items']").val("No")
      $(this).css("color", "#888 !important")
      filter_items_now()
    }else{
      $("input[name='sort_by_popular_items']").val("Yes")
      $(this).css("color", "#0000ff !important")
      filter_items_now()
    }

  })
</script>
@endpush


