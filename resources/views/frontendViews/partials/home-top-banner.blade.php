
   <section class="slider d-flex align-items-center" 
   style="background: url('{{$home_top_banner}}');">
      <div class="container">
         <div class="row d-flex justify-content-center">
            <div class="col-md-12">
               <div class="slider-title_box">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="slider-content_wrap">
                           <h1 style="color: {{$home_banner_title_color}} !important">{{$home_banner_title}}</h1>
                           <h5 style="color: : {{$home_banner_description_color}} !important">{{$home_banner_description}}</h5>
                        </div>
                     </div>
                  </div>
                  <div class="row d-flex justify-content-center">
                     <div class="col-md-10">
                        <form class="form-wrap mt-4 top-search-form">
                           <div class="btn-group" role="group" aria-label="Basic example">
                              <input type="text" placeholder="{{$search_box_text}}" class="btn-group1 search" style="background: {{$search_box_bg_color}} !important">
                              <button type="submit" class="btn-form" 
                                 style="
                                 text-transform: uppercase;
                                 color: {{$search_button_text_color}};
                                 background: {{$search_button_bg_color}};
                                 ">
                                 <span class="icon-magnifier search-icon"></span>{{$search_button_text}}<i class="pe-7s-angle-right"></i>
                              </button>
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