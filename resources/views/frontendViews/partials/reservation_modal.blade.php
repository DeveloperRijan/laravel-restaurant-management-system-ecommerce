<!-- Modal -->
<div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="loginRegisterModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" style="background: #fff;padding: 25px">
         <div class="modal-header">
            <h5 class="modal-title" id="loginRegisterModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="main">

               <section class="sign-in">
                  <div class="container">
                     <div class="signin-content d-flex justify-content-between">

                        <div class="signin-image">
                           @if($frontendUIData)
                           <figure><img src="{{$publicAssetsPathStart.\Config::get('constants.FILE_PATH.ICON').$frontendUIData->reservation_image}}" alt="Reservation image"></figure>
                           @else
                           <figure><img src="{{$publicAssetsPathStart}}frontend/images/reservation_img.jpg" alt="Reservation image"></figure>
                           @endif
                        </div>

                        <div class="signin-form" style="width: 100%">
                           <h2 class="form-title" style="font-size: 20px; font-weight: 600; text-transform: uppercase; text-align: center; border-bottom: 1px solid #ddd; padding: 5px;margin-bottom: 25px">Reserve a Seat</h2>
                           <form id="reservationForm" action="{{route('login.post')}}" method="POST" class="register-form">
                              @csrf
                              <div class="form-group" style="margin-bottom: 15px">
                                 <label>Select Reservation Date</label>
                                 <input type="date" name="reservation_date" class="form-control" required="1">
                              </div>
                              <div class="form-group" style="margin-bottom: 15px">
                                 <label>Select Reservation Time</label>
                                 <input type="time" name="reservation_time" class="form-control" required="1">
                              </div>
                              <div class="form-group" style="margin-bottom: 15px">
                                 <button type="submit" class="btn btn-danger" style="cursor: pointer;">Make Reservation</button>
                              </div>
                           </form>
                        </div>

                     </div>
                  </div>
               </section>

            </div>
         </div>
      </div>
   </div>
</div>
