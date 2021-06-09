<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>{{env("APP_NAME")}} | Password Recovery</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" type="image/png" href="{{$publicAssetsPathStart}}backend/images/logo_default.png">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="{{$publicAssetsPathStart}}backend/plugins/font-awesome/css/font-awesome.min.css">
      <!-- Ionicons -->
      <link href="https://unpkg.com/ionicons@4.1.2/dist/css/ionicons.min.css" rel="stylesheet">
      <!-- Theme style -->
      <link rel="stylesheet" href="{{$publicAssetsPathStart}}backend/dist/css/adminlte.css">
      <!-- iCheck -->
      <link rel="stylesheet" href="{{$publicAssetsPathStart}}backend/plugins/iCheck/flat/blue.css">
      <!-- Google Font: Poppins -->
      <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,400i,700" rel="stylesheet">
      <link rel="stylesheet" href="{{$publicAssetsPathStart}}backend/css/custom.css">
      
      <style type="text/css">
         div.alert button.btn-close{
            display: none !important;
        }
      </style>
   </head>
   <body class="hold-transition login-page" style="">
      <div class="login-box">
         <div class="login-logo">
            <a href="{{url('/')}}"><img src="{{$publicAssetsPathStart}}backend/images/logo_default.png" alt="Smart Delivery"></a>
         </div>
         <!-- /.login-logo -->
         <div class="card">
            <div class="card-body login-card-body">
               <div class="card-body login-card-body">
                  <p class="login-box-msg">Password Recovery</p>
                  @include("msg.msg")

                  @if($request->token != '' && $request->email != '' && $request->userType != '')
                  
                  <form action="{{route('passwordReset.post')}}" method="POST">
                     @csrf
                       <input type="hidden" name="email" value="{{\Request::get('email')}}">
                       <input type="hidden" name="token" value="{{\Request::get('token')}}">
                       <input type="hidden" name="userType" value="{{\Request::get('userType')}}">
                     <div class="input-group mb-3">
                        <input value="" type="password" class="form-control " name="password" placeholder="New Password" aria-label="Email Address">
                        <div class="input-group-append">
                           <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </div>
                     </div>
                     <div class="input-group mb-3">
                        <input value="" type="password" class="form-control  " name="password_confirmation" placeholder="Password" aria-label="Password">
                        <div class="input-group-append">
                           <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </div>
                     </div>
                     <div class="row mb-2">
                        <!-- /.col -->
                        <div class="col-12">
                           <button type="submit" class="btn btn-primary btn-block">Update</button>
                        </div>
                        <!-- /.col -->
                     </div>
                  </form>

                  @else

                  <form action="{{route('sendPassResetLink.post')}}" method="post">
                     @csrf
                     <input type="hidden" name="userType" value="{{\Request::get('userType')}}">
                     <div class="input-group mb-3">
                        <input value="" type="email" class="form-control " name="email" placeholder="Email Address" aria-label="Email Address" required="1">
                        <div class="input-group-append">
                           <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                        </div>
                     </div>
                     <div class="row mb-2">
                        <div class="col-12">
                           <button type="submit" class="btn btn-primary btn-block">Get Reset Link</button>
                        </div>
                        <!-- /.col -->
                     </div>
                  </form>
                  @endif



                  <!-- /.social-auth-links -->
                  <p class="mb-1 text-center">
                     <a href="{{url('/')}}">Home</a>
                  </p>
               </div>
            </div>
         </div>
      </div>
      <!-- /.login-box -->
      <!-- jQuery -->
      <script src="{{$publicAssetsPathStart}}backend/plugins/jquery/jquery.min.js"></script>
      <!-- Bootstrap 4 -->
      <script src="{{$publicAssetsPathStart}}backend/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- iCheck -->
      <script src="{{$publicAssetsPathStart}}backend/plugins/iCheck/icheck.min.js"></script>
      <script>
         $(function () {
             $('.icheck input').iCheck({
                 checkboxClass: 'icheckbox_flat-blue',
                 radioClass: 'iradio_flat-blue',
                 increaseArea: '20%' // optional
             })
         })
      </script>
   </body>
</html>