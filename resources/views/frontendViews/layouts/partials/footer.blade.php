  @if($frontendUIData)  
    <section id="appDownload" class="app-section">
        <div class="container inner_app">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="app_image">
                        <div class="appImg">
                            <img src="{{$publicAssetsPathStart}}frontend/images/app_footer.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="app_details">
                        <h3 style="color: {{$frontendUIData->app_section_title_color}}">{{$frontendUIData->app_section_title}}</h3>
                        <p style="color: {{$frontendUIData->app_section_description_color}}">{{$frontendUIData->app_section_description}}</p>
                        <div class="download d-flex justify-content-start">
                          @if($frontendUIData->play_store_app_link != '')
                            <a href="{{$frontendUIData->play_store_app_link}}"><img src="{{$publicAssetsPathStart}}frontend/images/playstore.png" alt=""></a>
                            @else
                            <a href="#"><img src="{{$publicAssetsPathStart}}frontend/images/playstore.png" alt=""></a>
                          @endif

                          @if($frontendUIData->apple_app_link != '')
                            <a href="{{$frontendUIData->apple_app_link}}"><img src="{{$publicAssetsPathStart}}frontend/images/appstore.png" alt=""></a>
                            @else
                            <a href="#"><img src="{{$publicAssetsPathStart}}frontend/images/appstore.png" alt=""></a>
                          @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  @endif



    <section id="footer_section">
        
        <div class="bottomFooterBoxWrapper container">

            <div class="row">

              <div class="col-lg-4 col-md-4 col-sm-12">
                  <div class="footer_box2">
                      <h4>Payment Option</h4>
                      <div class="payment">
                          <img src="{{$publicAssetsPathStart}}frontend/images/pay.png" alt="">
                      </div>
                  </div>
              </div>

              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="footer_box2">
                   <h4>Address</h4>
                   @if($frontendUIData)
                        @if($frontendUIData->contact_address != '')
                        <p>
                            <?php
                              $ex_addr = explode('##,', $frontendUIData->contact_address);
                              foreach ($ex_addr as $key => $line) {
                                echo $line."<br>";
                              }
                            ?>
                        </p>
                        @endif

                        @if($frontendUIData->contact_phone != '')
                        <h4 class="m-0">Phone: <span>{{$frontendUIData->contact_phone}}</span></h4>
                        @endif

                       @if($frontendUIData->contact_email != '')
                        <h4 class="m-0">Email: <span>{{$frontendUIData->contact_email}}</span></h4>
                       @endif
                   @endif
                </div>
              </div>


              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="footer_box2">
                  <h4>Social Media</h4>
                 @if($frontendUIData)
                   <div>
                     <ul class="social-icons">
                      @if($frontendUIData->facebook_url != '')
                      <li>
                        <a href="{{$frontendUIData->facebook_url}}">
                          <img src="{{$publicAssetsPathStart}}uploads/icons/fb-300.png">
                        </a>
                      </li>
                      @endif

                      @if($frontendUIData->twitter_url != '')
                      <li>
                        <a href="{{$frontendUIData->twitter_url}}">
                          <img src="{{$publicAssetsPathStart}}uploads/icons/twitter-300.png">
                        </a>
                      </li>
                      @endif

                      @if($frontendUIData->linkedIn_url != '')
                      <li>
                        <a href="{{$frontendUIData->linkedIn_url}}">
                          <img src="{{$publicAssetsPathStart}}uploads/icons/linkedin-300.png">
                        </a>
                      </li>
                      @endif

                      @if($frontendUIData->youtube_url != '')
                      <li>
                        <a href="{{$frontendUIData->youtube_url}}">
                          <img src="{{$publicAssetsPathStart}}uploads/icons/youtube-300.png">
                        </a>
                      </li>
                      @endif

                      @if($frontendUIData->instagram_url != '')
                      <li>
                        <a href="{{$frontendUIData->instagram_url}}">
                          <img src="{{$publicAssetsPathStart}}uploads/icons/instagram-300.png">
                        </a>
                      </li>
                      @endif
                   </ul>
                   </div>
                @endif
              </div>
              </div>

            </div>
            

        </div>

    </section>

    <div id="loadDynamicProductDetailsHTML">
      @include("frontendViews.partials.product_details_modal")
    </div>
    
    @include("frontendViews.partials.login_register_modal")
    @include("frontendViews.partials.order_modal")
    @include("frontendViews.partials.reservation_modal")
    @include("processing_gif.processing_gif")

    <!-- scripts -->
    <script type="text/javascript" src="{{$publicAssetsPathStart}}frontend/js/jquery.min.js"></script>
    <script type="text/javascript" src="{{$publicAssetsPathStart}}frontend/js/jquery-ui.js"></script>
    <script type="text/javascript" src="{{$publicAssetsPathStart}}frontend/js/popper.min.js"></script>
    <script type="text/javascript" src="{{$publicAssetsPathStart}}frontend/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{$publicAssetsPathStart}}frontend/js/jquery.backstretch.min.js"></script>
    
    <script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/form_submitter/general-form-submit.js"></script>
    <script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/sw_alert/sweetalert2@10.js"></script>
    <script src="{{$publicAssetsPathStart}}frontend/js/scripts.js"></script>
    <script src="{{$publicAssetsPathStart}}frontend/js/product_options.js"></script>
    

    @if(\Session::has("sw_alert_session_success"))
      <script type="text/javascript">
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: "{{Session::get('sw_alert_session_success')}}",
          footer: ""
        });
      </script>
    @endif

    @if(\Session::has("sw_alert_session_error"))
      <script type="text/javascript">
        Swal.fire({
          icon: 'info',
          title: 'Sorry',
          text: "{{Session::get('sw_alert_session_error')}}",
          footer: ""
        });
      </script>
    @endif

    @stack("scripts")

    <script type="text/javascript">
      //mobile menu control
      $("button#toggleMenuBar").on("click", function(){
        let trackState = $(this).attr("trackstate")
        if (trackState === "menu_hide") {
          $("#mobile--menu").removeClass("d-none")
          $(this).attr("trackstate", "menu_show")
        }else{
          $("#mobile--menu").addClass("d-none")
          $(this).attr("trackstate", "menu_hide")
        }
      })
    </script>


    <script type="text/javascript">
      $(".menuSection div.logo_area").on("click", function(){
        window.location.href = "{{url('/')}}"
      })
    </script>

    <?php
      $sliders = \App\Models\Slider::orderBy("created_at", "ASC")->get();
      $sliderImages = [];
      foreach ($sliders as $key => $row) {
        $sliderImages[] = $publicAssetsPathStart.Config::get('constants.FILE_PATH.SLIDERS').$row->image;
      }
    ?>
    <script type="text/javascript">
      //var sliderImageList = "{{json_encode($sliderImages)}}";
      var sliderImageList = {!! json_encode($sliderImages) !!};
      console.log(sliderImageList)

      $("#header").backstretch(
      sliderImageList, 
      {
        duration: 6000, 
        fade: 1000
      });
    </script>



    @if(Auth::check() && Auth::user()->type === "Customer")
    <script type="text/javascript">
      //if clicked order btn then
      $("#loadDynamicProductDetailsHTML").on("click", "a.order-now-link", function(e){
        e.preventDefault()
        let qty = $("#loadDynamicProductDetailsHTML input[name='qty']").val()
        let productID = $("#loadDynamicProductDetailsHTML input[name='product_id']").val()
        //window.location.href = "{{route('orderNow.item')}}?product_id="+productID+"&qty="+qty
      })
    </script>
    @elseif(Auth::check() && Auth::user()->type === "Staff")
    <script type="text/javascript">
      //if clicked order btn then
      $("#loadDynamicProductDetailsHTML").on("click", "a.order-now-link", function(e){
        e.preventDefault()
        let qty = $("#loadDynamicProductDetailsHTML input[name='qty']").val()
        let productID = $("#loadDynamicProductDetailsHTML input[name='product_id']").val()
        //window.location.href = "{{route('orderNow.item')}}?product_id="+productID+"&qty="+qty
      })
    </script>
    @else
    <script type="text/javascript">
      //if clicked order btn then
      $("#loadDynamicProductDetailsHTML").on("click", "a.order-now-link", function(e){
        e.preventDefault()        
      })
    </script>
    @endif
</body>

</html>