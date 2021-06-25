
<!-- Modal -->
@if(request()->is('*staff*'))

<div class="modal fade" id="loginRegisterModal" tabindex="-1" aria-labelledby="loginRegisterModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" style="background: #fff">
         <div class="modal-header" style="border-bottom: none;">
            <h5 class="modal-title" id="loginRegisterModalLabel"></h5>
            <button type="button" class="close loginModalCloseBTN" data-dismiss="modal" aria-label="Close" style="background: transparent; border: none; font-size: 20px;">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="main">

               <section class="signup" style="display: none;">
                  <div class="container">
                     <div class="signup-content d-flex justify-content-between">
                        <div class="signup-form" style="width: 100%">
                           <h2 class="form-title">Sign up</h2>
                           <form method="POST" class="register-form" id="register-form" action="{{route('staff.register.post')}}">
                              @csrf
                              <div class="form-group">
                                 <label for="name"><i class="zmdi fas fa-user"></i></label>
                                 <input type="text" name="name" id="name" placeholder="* Your Name">
                              </div>
                              <div class="form-group">
                                 <label for="email"><i class="zmdi fas fa-envelope"></i></label>
                                 <input type="email" name="email" id="email" placeholder="* Your Email">
                              </div>
                              <div class="form-group">
                                 <label for="phone"><i class="zmdi fas fa-phone"></i></label>
                                 <input type="tel" name="phone" id="phone" placeholder="* Your Phone">
                              </div>
                              
                              <div class="form-group">
                                 <label for="address_line_one"><i class="zmdi fas fa-map"></i></label>
                                 <input type="text" name="address_line_one" id="address_line_one" placeholder="* Address line one">
                              </div>
                              <div class="form-group">
                                 <label for="address_line_two"><i class="zmdi fas fa-map"></i></label>
                                 <input type="text" name="address_line_two" id="address_line_two" placeholder="Address line two">
                              </div>
                              <div class="form-group">
                                 <label for="city"><i class="zmdi fas fa-map-marker"></i></label>
                                 <input type="text" list="cities_list" name="city" id="city" placeholder="* City">
                                 <datalist list="cities_list" id="cities_list">
                                    @foreach(\Config::get("constants.SEPECIAL_CITIES") as $key=>$city)
                                    <option value="{{$city}}">{{$city}}</option>
                                    @endforeach
                                 </datalist>
                              </div>
                              <div class="form-group">
                                 <label for="state"><i class="zmdi fas fa-map-marker"></i></label>
                                 <input type="text" name="state" id="state" placeholder="* State">
                              </div>


                              <div class="form-group">
                                 <label for="company"><i class="zmdi fas fa-box"></i></label>
                                 <select name="company" id="company" style="width: 100%; display: block; border: none; border-bottom: 1px solid #999; padding: 6px 30px; font-family: Poppins; box-sizing: border-box;">
                                    <option value="">Select Company</option>
                                    <?php
                                       //get designatins
                                       $companies = \App\Models\Company::where('status', "Active")->orderBy("name", "ASC")->get();
                                       foreach ($companies as $key => $com) {
                                          echo "<option value='".$com->id."'>".$com->name.' - '.$com->code."</option>";
                                       }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group">
                                 <label for="designation"><i class="zmdi fas fa-user-shield"></i></label>
                                 <select name="designation" id="designation" style="width: 100%; display: block; border: none; border-bottom: 1px solid #999; padding: 6px 30px; font-family: Poppins; box-sizing: border-box;">
                                    <option value="">Select Designation</option>
                                    <?php
                                       //get designatins
                                       $designations = \App\Models\Designation::orderBy("title", "ASC")->get();
                                       foreach ($designations as $key => $des) {
                                          echo "<option value='".$des->id."'>".$des->title."</option>";
                                       }
                                    ?>
                                 </select>
                              </div>

                              <div class="form-group">
                                 <label for="pass"><i class="zmdi fas fa-lock"></i></label>
                                 <input type="password" name="password" id="pass" placeholder="Password">
                              </div>
                              <div class="form-group">
                                 <label for="re-pass"><i class="zmdi fas fa-lock"></i></label>
                                 <input type="password" name="password_confirmation" id="re_pass" placeholder="Repeat your password">
                              </div>
                              <div class="form-group">
                                 <input type="checkbox" name="agree-term" id="agree-term" class="agree-term">
                                 <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in <a href="#" class="term-service">Terms of service</a></label>
                              </div>
                              <div class="form-group form-button">
                                 <input type="submit" name="signup" id="signup" class="form-submit" value="Register">
                              </div>
                              <div class="form-group text-center">
                                 <a onclick="showSignInForm(event)" href="" class="signup-image-link">I am already member</a>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </section>

               <section class="sign-in">
                  <div class="container">
                     <div class="signin-content d-flex justify-content-between">

                        <div class="signin-image">
                           @if($frontendUIData)
                           <figure><img src="{{$publicAssetsPathStart.\Config::get('constants.FILE_PATH.ICON').$frontendUIData->singin_image}}" alt="sing in image"></figure>
                           @else
                           <figure><img src="{{$publicAssetsPathStart}}frontend/images/signin-image.jpg" alt="sing up image"></figure>
                           @endif
                           <a onclick="showSignUpForm(event)" href="" class="signup-image-link">Register an account</a>
                        </div>

                        <div class="signin-form">
                           <h2 class="form-title">Sign in</h2>
                           <form action="{{route('staff.login.post')}}" method="POST" class="register-form" id="login-form">
                              @csrf
                              <div class="form-group">
                                 <label for="login_email"><i class="zmdi fas fa-user"></i></label>
                                 <input type="text" name="email" id="login_email" placeholder="Your Email">
                              </div>
                              <div class="form-group">
                                 <label for="your_pass"><i class="zmdi fas fa-lock"></i></label>
                                 <input type="password" name="password" id="your_pass" placeholder="Password">
                              </div>

                              <div class="form-group d-flex justify-content-between">
                                 <div class="form-group">
                                    <input type="checkbox" name="remember-me" id="remember-me" class="agree-term">
                                    <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                                 </div>
                                 <div class="form-group">
                                    <a href="{{route('resetPassForm.get')}}?userType={{encrypt('Staff')}}" class="label-agree-term"><span><span></span></span>Forgot Password?</a>
                                 </div>
                              </div>

                              <div class="form-group form-button">
                                 <input type="submit" name="signin" id="signin" class="form-submit" value="Sign in">
                              </div>
                           </form>
                           <div class="social-login" style="display: none;">
                              <span class="social-label">Or login with</span>
                              <ul class="socials">
                                 <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                 <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                 <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                              </ul>
                           </div>
                        </div>

                     </div>
                  </div>
               </section>

            </div>
         </div>
      </div>
   </div>
</div>

@else

<div class="modal fade" id="loginRegisterModal" tabindex="-1" aria-labelledby="loginRegisterModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" style="background: #fff">
         <div class="modal-header" style="border-bottom: none;">
            <h5 class="modal-title" id="loginRegisterModalLabel"></h5>
            <button type="button" class="close loginModalCloseBTN" data-dismiss="modal" aria-label="Close" style="background: transparent; border: none; font-size: 20px;">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="main">

               <section class="signup" style="display: none;">
                  <div class="container">
                     <div class="signup-content d-flex justify-content-between">
                        <div class="signup-form">
                           <h2 class="form-title">Sign up</h2>
                           <form method="POST" class="register-form" id="register-form" action="{{route('register.post')}}">
                              @csrf
                              <div class="form-group">
                                 <label for="name"><i class="zmdi fas fa-user"></i></label>
                                 <input type="text" name="name" id="name" placeholder="Your Name">
                              </div>
                              <div class="form-group">
                                 <label for="email"><i class="zmdi fas fa-envelope"></i></label>
                                 <input type="email" name="email" id="email" placeholder="Your Email">
                              </div>
                              <div class="form-group">
                                 <label for="phone"><i class="zmdi fas fa-phone"></i></label>
                                 <input type="tel" name="phone" id="phone" placeholder="Your Phone">
                              </div>
                              <div class="form-group">
                                 <label for="pass"><i class="zmdi fas fa-lock"></i></label>
                                 <input type="password" name="password" id="pass" placeholder="Password">
                              </div>
                              <div class="form-group">
                                 <label for="re-pass"><i class="zmdi fas fa-lock"></i></label>
                                 <input type="password" name="password_confirmation" id="re_pass" placeholder="Repeat your password">
                              </div>
                              <div class="form-group">
                                 <input type="checkbox" name="agree-term" id="agree-term" class="agree-term">
                                 <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in <a href="#" class="term-service">Terms of service</a></label>
                              </div>
                              <div class="form-group form-button">
                                 <input type="submit" name="signup" id="signup" class="form-submit" value="Register">
                              </div>
                           </form>
                        </div>
                        <div class="signup-image">
                           @if($frontendUIData)
                           <figure><img src="{{$publicAssetsPathStart.\Config::get('constants.FILE_PATH.ICON').$frontendUIData->signup_image}}" alt="sing up image"></figure>
                           @else
                           <figure><img src="{{$publicAssetsPathStart}}frontend/images/signup-image.jpg" alt="sing in image"></figure>
                           @endif
                           <a onclick="showSignInForm(event)" href="" class="signup-image-link">I am already member</a>
                        </div>
                     </div>
                  </div>
               </section>

               <section class="sign-in">
                  <div class="container">
                     <div class="signin-content d-flex justify-content-between">

                        <div class="signin-image">
                           @if($frontendUIData)
                           <figure><img src="{{$publicAssetsPathStart.\Config::get('constants.FILE_PATH.ICON').$frontendUIData->singin_image}}" alt="sing in image"></figure>
                           @else
                           <figure><img src="{{$publicAssetsPathStart}}frontend/images/signin-image.jpg" alt="sing up image"></figure>
                           @endif
                           <a onclick="showSignUpForm(event)" href="" class="signup-image-link">Register an account</a>
                        </div>

                        <div class="signin-form">
                           <h2 class="form-title">Sign in</h2>
                           <form action="{{route('login.post')}}" method="POST" class="register-form" id="login-form">
                              @csrf
                              <div class="form-group">
                                 <label for="login_email"><i class="zmdi fas fa-user"></i></label>
                                 <input type="text" name="email" id="login_email" placeholder="Your Email">
                              </div>
                              <div class="form-group">
                                 <label for="your_pass"><i class="zmdi fas fa-lock"></i></label>
                                 <input type="password" name="password" id="your_pass" placeholder="Password">
                              </div>

                              <div class="form-group d-flex justify-content-between">
                                 <div class="form-group">
                                    <input type="checkbox" name="remember-me" id="remember-me" class="agree-term">
                                    <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                                 </div>
                                 <div class="form-group">
                                    <a href="{{route('resetPassForm.get')}}?userType={{encrypt('Customer')}}" class="label-agree-term"><span><span></span></span>Forgot Password?</a>
                                 </div>
                              </div>

                              <div class="form-group form-button">
                                 <input type="submit" name="signin" id="signin" class="form-submit" value="Sign in">
                              </div>
                           </form>
                           <div class="social-login" style="display: none;">
                              <span class="social-label">Or login with</span>
                              <ul class="socials">
                                 <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                 <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                 <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                              </ul>
                           </div>
                        </div>

                     </div>
                  </div>
               </section>

            </div>
         </div>
      </div>
   </div>
</div>

@endif


@push("scripts")

<script type="text/javascript">
   $("#loginRegisterModal form#login-form").on('submit', function(e){
         e.preventDefault();
         var form = $(this);
         var url = form.attr('action');
         var type = form.attr('method');
         //var form_data = form.serialize();
   
         formSubmitWithFile("login-form", url, type);
     })
</script>

<script type="text/javascript">
   $("#loginRegisterModal form#register-form").on('submit', function(e){
         e.preventDefault();
         var form = $(this);
         var url = form.attr('action');
         var type = form.attr('method');
         //var form_data = form.serialize();
   
         formSubmitWithFile("register-form", url, type);
     })
</script>
@endpush