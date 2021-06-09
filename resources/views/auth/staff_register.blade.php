<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>{{env("APP_NAME")}} | Admin Login</title>
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
            @include("msg.msg")

            @if(\Request::get('staff_id') != '' && !$invitationData)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Invitation Data invalid | please fill the form manually to register
            </div>
            @endif

            <div class="card-body login-card-body">
               <div class="card-body login-card-body">
                  <p class="login-box-msg"><i class="fa fa-user"></i> Staff Register</p>
                  <?php
                     $name = NULL;
                     $email = NULL;
                     $staffID = NULL;
                     if($invitationData != NULL){
                        $name = $invitationData->name;
                        $email = $invitationData->email;
                        $staffID = $invitationData->staff_id;
                     }
                  ?>
                  <form action="{{route('staff.register.post')}}" method="post">
                     @csrf
                     <div class="input-group mb-3">
                        @if($name != NULL)
                        <input value="{{$name}}" type="text" class="form-control " name="name" placeholder="Name" aria-label="Name">
                        @else
                        <input value="{{old('name')}}" type="text" class="form-control " name="name" placeholder="Name" aria-label="Name">
                        @endif
                        <div class="input-group-append">
                           <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                     </div>
                     <div class="input-group mb-3">
                        @if($email != NULL)
                        <input readonly="1" value="{{$email}}" type="email" class="form-control " name="email" placeholder="Email Address" aria-label="Email Address">
                        @else
                        <input value="{{old('email')}}" type="email" class="form-control " name="email" placeholder="Email Address" aria-label="Email Address">
                        @endif
                        <div class="input-group-append">
                           <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                        </div>
                     </div>
                     <div class="input-group mb-3">
                        <input value="{{old('phone')}}" type="tel" class="form-control " name="phone" placeholder="Phone" aria-label="Phone">
                        <div class="input-group-append">
                           <span class="input-group-text"><i class="fa fa-phone"></i></span>
                        </div>
                     </div>
                     <div class="input-group mb-3">
                        <input value="" type="password" class="form-control  " name="password" placeholder="Password" aria-label="Password">
                        <div class="input-group-append">
                           <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </div>
                     </div>
                     <div class="input-group mb-3">
                        <input value="" type="password" class="form-control  " name="password_confirmation" placeholder="Password Confirm" aria-label="Password">
                        <div class="input-group-append">
                           <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </div>
                     </div>
                     <div class="input-group mb-3">
                        @if($staffID != NULL)
                        <input readonly="1" value="{{$staffID}}" type="text" class="form-control " name="staff_id" placeholder="Staff ID (Code)" aria-label="Staff ID (Code)">
                        @else
                        <input value="" type="text" class="form-control " name="staff_id" placeholder="Staff ID (Code)" aria-label="Staff ID (Code)">
                        @endif
                        <div class="input-group-append">
                           <span class="input-group-text"><i class="fa fa-map-pin"></i></span>
                        </div>
                     </div>
                     <div class="row mb-2">
                        <!-- /.col -->
                        <div class="col-12">
                           <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <div class="col-12 mt-2">
                           <a href="{{route('staff.login.form')}}" class="btn btn-info btn-block">Login</a>
                        </div>
                        <!-- /.col -->
                     </div>
                  </form>
                  <!-- /.social-auth-links -->
                  <p class="mb-1 text-center">
                     <a href="{{route('resetPassForm.get')}}?userType={{encrypt('Admin')}}">I forgot my password</a>
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