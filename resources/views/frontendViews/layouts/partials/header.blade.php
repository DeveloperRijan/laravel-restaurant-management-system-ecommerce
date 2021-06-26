<?php
   $home_top_banner = "#212121";
   $home_banner_title = NULL;
   $home_banner_title_color = NULL;
   $home_banner_description = NULL;
   $search_box_bg_color = NULL;
   $search_box_text = NULL;
   //$search_box_text_color = NULL;
   $search_button_text = NULL;
   $search_button_text_color = NULL;
   $search_button_bg_color = NULL;
   $app_section_bg_color = "#e8500e";

   if ($frontendUIData) {
      //bg image
      if ($frontendUIData->home_top_banner != '') {
         $home_top_banner = $publicAssetsPathStart.\Config::get('constants.FILE_PATH.BANNER').$frontendUIData->home_top_banner;
      }
      //title
      $home_banner_title = $frontendUIData->home_banner_title;
      $home_banner_title_color = $frontendUIData->home_banner_title_color;
      $home_banner_description = $frontendUIData->home_banner_description;
      $home_banner_description_color = $frontendUIData->home_banner_description_color;
      $search_box_bg_color = $frontendUIData->search_box_bg_color;
      $search_box_text = $frontendUIData->search_box_text;
      //$search_box_text_color = $frontendUIData->search_box_text_color;
      $search_button_text = $frontendUIData->search_button_text;
      $search_button_text_color = $frontendUIData->search_button_text_color;
      $search_button_bg_color = $frontendUIData->search_button_bg_color;

      $app_section_bg_color = $frontendUIData->app_section_bg_color;

   }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{$publicAssetsPathStart}}uploads/app/app_logo.png">
    <title>@if($frontendUIData) {{$frontendUIData->app_title}} @else {{env("APP_NAME")}} @endif</title>

    <link rel="stylesheet" href="{{$publicAssetsPathStart}}frontend/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{$publicAssetsPathStart}}frontend/css/all.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{$publicAssetsPathStart}}frontend/css/jquery-ui.css" />

    <link rel="stylesheet" href="{{$publicAssetsPathStart}}frontend/css/style.css" />
    <link rel="stylesheet" href="{{$publicAssetsPathStart}}frontend/css/addition_style.css" />
    <link rel="stylesheet" href="{{$publicAssetsPathStart}}frontend/css/custom.css" />
    <link rel="stylesheet" href="{{$publicAssetsPathStart}}frontend/css/signup-signin.css" />
    <link rel="stylesheet" href="{{$publicAssetsPathStart}}plugins/processing_gif/form-processing-style.css" />
    <link rel="stylesheet" href="{{$publicAssetsPathStart}}frontend/css/product_options.css" />
    <link rel="stylesheet" href="{{$publicAssetsPathStart}}frontend/css/responsive.css" />


    @stack("styles")

    @if($frontendUIData)
      <style type="text/css">
         form.top-search-form input.search::placeholder{
            color: {{$frontendUIData->search_box_text_color}} !important
         }
      </style>
   @endif


   @if(!\Request::is("*customer*"))
   <style type="text/css">
     #header {
         background-size: cover;
        background-repeat: no-repeat;
        width: 100%;
        height: 80%;
        background-position: center;
      }
   </style>
   @endif

   <style type="text/css">
      .app-section::before,
      .app-section::after{
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        height: 12px;
        background-repeat: repeat-x;
        background-position: left center;
        width: 100%;
        height: 100%;
        background: {{$app_section_bg_color}};
        z-index: -1;
      }
   </style>


   @if(\Request::is('*customer*') ||  \Request::is('*staff/account*'))
    <style type="text/css">
      #home--hero--banner{
        display: none;
      }
    </style>
   @endif

   @if(\Request::route()->getName() === 'staff.order.page')
    <style type="text/css">
      #home--hero--banner{
        display: none;
      }
    </style>
   @endif

</head>

<body>

    <!-- Header Section starts -->
    <header id="header">
      <button trackstate="menu_hide" id="toggleMenuBar" type="button"><i class="fas fa-bars"></i></button>
      <div class="menuSection">
          <div class="logo_area">
              <img src="{{$publicAssetsPathStart}}uploads/app/app_logo.png" alt="Logo" />
          </div>
          <div class="container top_menuArea">
            <div class="menu_area">
                <ul>
                    <li>
                      @if(!request()->is('*staff*'))
                        <a href="{{route('item.list.page')}}">Foods</a>
                      @else
                        <a href="{{route('staff.item.list.page')}}">Foods</a>
                      @endif
                    </li>

                    @if(!request()->is('*staff*'))
                    <li style="position: relative;" class="destop--v">
                        <a href="{{route('checkout.init')}}">
                           <span class="cart_item_count">0</span>
                           <img src="{{$publicAssetsPathStart}}frontend/images/shopping-cart.png" width="25px">
                        </a>
                    </li>
                    @endif

                    <li class="account_menu">
                        @if(Auth::check())
                           @if(Auth::user()->type === "Customer")
                              <a href="{{route('customer.account.get')}}?data=profile">Account</a>
                           @elseif(Auth::user()->type === "Staff")
                            <a href="{{route('staff.account.get')}}?data=profile">Account</a>
                           @elseif(Auth::user()->type === "Kitchen Staff")
                            <a href="{{route('ks.dashboard')}}">Dashboard</a>
                           @else
                              <a href="{{route('admin.dashboard')}}">Account</a>
                           @endif
                        @else
                              <a href="" class="topSignInSignUpLink">Login/Register</a>
                        @endif
                    </li>
                </ul>
            </div>
          </div>
      </div>

      <div class="d-none" id="mobile--menu">
        <div class="mobile_menu_wrapper">
          <ul>
              <li>
                @if(!request()->is('*staff*'))
                  <a href="{{route('item.list.page')}}">Foods</a>
                @else
                  <a href="{{route('staff.item.list.page')}}">Foods</a>
                @endif
              </li>

              @if(!request()->is('*staff*'))
              <li style="position: relative;" class="destop--v">
                  <a href="{{route('checkout.init')}}">
                    Cart (<span class="cart_item_count">0</span>)
                  </a>
              </li>
              @endif

              <li class="account_menu">
                  @if(Auth::check())
                     @if(Auth::user()->type === "Customer")
                        <a href="{{route('customer.account.get')}}?data=profile">Account</a>
                     @elseif(Auth::user()->type === "Staff")
                      <a href="{{route('staff.account.get')}}?data=profile">Account</a>
                     @elseif(Auth::user()->type === "Kitchen Staff")
                      <a href="{{route('ks.dashboard')}}">Dashboard</a>
                     @else
                        <a href="{{route('admin.dashboard')}}">Account</a>
                     @endif
                  @else
                        <a href="" class="topSignInSignUpLink" style="border: none;">Login/Register</a>
                  @endif
              </li>
          </ul>
      </div>
      </div>

    
    @include("frontendViews.layouts.partials.banner")

    </header>
    <!-- Header Section ends -->


