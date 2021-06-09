@extends("frontendViews.layouts.master")


@push("styles")
<link rel="stylesheet" href="{{$publicAssetsPathStart}}frontend/css/style.css">
@endpush

@section("content")
  
  <div class="single-item-page">
    
    <div class="container">
        <div class="row">
          <div class="col-lg-5 col-md-6 col-sm-12">
            <div class="carosuel-wrapper">
              @include("frontendViews.items.partials.carosuel")
            </div>
          </div>

          <div class="col-lg-7 col-md-6 col-sm-12">
            <div class="item-details-wrapper">
              @include("frontendViews.items.partials.right")
            </div>
          </div>
        </div>
    </div>


    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <section class="light-bg booking-details_wrap">
           <div class="container">
              <div class="row">
                @if($product->field_names != null && $product->field_values != NULL)
                  <div class="col-lg-8 col-md-8 responsive-wrap">
                      <div class="booking-checkbox_wrap">
                         <div class="booking-checkbox">
                            {!! nl2br(e($product->description)) !!}
                            <hr>
                         </div>
                      </div>
                   </div>
                   <div class="col-lg-4 col-md-4 responsive-wrap">
                      <div class="booking-checkbox_wrap">
                         <div class="booking-checkbox">
                            <table class="table">
                              <?php
                                  $field_names = json_decode($product->field_names);
                                  $field_values = json_decode($product->field_values);
                                  foreach ($field_names as $key => $name) {
                                      echo "<tr>";
                                        echo "<td>".$name."</td>";
                                        echo "<td>".$field_values[$key]."</td>";
                                      echo "</tr>";
                                  }
                              ?>
                            </table>
                            <hr>
                         </div>
                      </div>
                   </div>
                @else
                  <div class="col-md-12 responsive-wrap">
                      <div class="booking-checkbox_wrap">

                         <div class="booking-checkbox">
                            {!! nl2br(e($product->description)) !!}
                            <hr>
                         </div>
                      </div>
                   </div>
                @endif

              </div>
           </div>
        </section>
      </div>
    </div>

  </div>
    
@endsection


@push("scripts")

@endpush