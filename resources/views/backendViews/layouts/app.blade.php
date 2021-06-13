<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | {{env("APP_NAME")}}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" type="image/x-icon" href="{{$publicAssetsPathStart}}uploads/app/app_logo.png">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{$publicAssetsPathStart}}backend/plugins/font-awesome/css/font-awesome.min.css">

    <!-- Ionicons -->

    @stack('css_lib')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{$publicAssetsPathStart}}backend/dist/css/adminlte.css">
    <link rel="stylesheet" href="{{$publicAssetsPathStart}}backend/plugins/bootstrap-sweetalert/sweetalert.css">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600" rel="stylesheet">
    <link rel="stylesheet" href="{{$publicAssetsPathStart}}backend/css/custom.css">
    <link rel="stylesheet" href="{{$publicAssetsPathStart}}plugins/processing_gif/form-processing-style.css" />
    <link rel="stylesheet" href="{{$publicAssetsPathStart}}backend/css/primary.css">
    @yield('css_custom')
    @stack("styles")
    <style type="text/css">
        div.alert button.btn-close{
            display: none !important;
        }

        span.countNewOrders{
            position: absolute;
            top: 9px;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 11px;
        }
        span.countNewOrders
        {
            position: absolute;
            top: 5px;
            left: 51%;
            transform: translate(-50%, -50%);
            font-size: 11px;
        }
        span.countNotifications{
            position: absolute;
            top: 7px;
            left: 59%;
            transform: translate(-50%, -50%);
            font-size: 11px;
        }
    </style>
</head>

<body style="height: 100%; background-color: #f9f9f9;" class="hold-transition sidebar-mini primary">

    <div class="wrapper">
        <!-- Main Header -->
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light bg-white border-bottom">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{route('admin.dashboard')}}" class="nav-link">Dashboard</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('orders*') ? 'active' : '' }}" href="{{route('admin.orders.index')}}?type=New">
                        <?php
                            $countPendingOrders = \App\Models\Order::where('status', "New")->count();
                        ?>
                        <span class="countNewOrders">{{$countPendingOrders}}</span> <i class="fa fa-shopping-cart"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('notifications*') ? 'active' : '' }}" href="{{route('admin.notifications.index')}}" style="position: relative;">
                        <?php
                            $countNotifications = \App\Models\Notification::where(['for'=>"admin", 'status'=>0])->count();
                        ?>
                        <span class="countNotifications">{{$countNotifications}}</span> <i class="fa fa-bell"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" style="position: relative;">
                        <img src="{{$publicAssetsPathStart}}backend/images/avatar_default.png" class="brand-image mx-2 img-circle elevation-2" alt="User Image">
                        <i class="fa fa fa-angle-down"></i> {!! auth()->user()->name !!}

                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{route('admin.profile.get')}}" class="dropdown-item"> <i class="fa fa-user mr-2"></i> Profile </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-envelope mr-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Left side column. contains the logo and sidebar -->
        @include('backendViews.layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright © {{date('Y')}} <a href="{{url('/')}}">{{env('APP_NAME')}}</a>.</strong> All rights reserved.
        </footer>

    </div>
    @include("processing_gif.processing_gif")


    <!-- jQuery -->
    <script src="{{$publicAssetsPathStart}}backend/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
   
    <!-- Bootstrap 4 -->
    <script src="{{$publicAssetsPathStart}}backend/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    

    <!-- datepicker -->
    <script src="{{$publicAssetsPathStart}}backend/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <!-- Slimscroll -->
    <script src="{{$publicAssetsPathStart}}backend/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="{{$publicAssetsPathStart}}backend/plugins/bootstrap-sweetalert/sweetalert.min.js"></script>
    <!-- FastClick -->

    @stack('scripts_lib')
    <!-- AdminLTE App -->
    <script src="{{$publicAssetsPathStart}}backend/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{$publicAssetsPathStart}}backend/dist/js/demo.js"></script>

    <script src="{{$publicAssetsPathStart}}backend/js/scripts.js"></script>
    @stack('scripts')
</body>
</html>