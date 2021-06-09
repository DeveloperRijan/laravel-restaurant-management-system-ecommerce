@extends('backendViews.layouts.app')

@push("styles")
<style type="text/css">
  input[type=color]{
    height: 39px
  }
</style>
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Frontend UI<small class="ml-3 mr-3">|</small><small>Frontend UI</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item active">Frontend UI</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="content">
  <div class="clearfix"></div>
  
  @include("msg.msg")
  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
        <li class="nav-item">
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>Fronted UI</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <?php
        $logoLocation = \Config::get("constants.PUBLIC.ASSETS_START_PATH").\Config::get("constants.FILE_PATH.LOGO");
        $iconLocation = \Config::get("constants.PUBLIC.ASSETS_START_PATH").\Config::get("constants.FILE_PATH.ICON");
        $bannerLocation = \Config::get("constants.PUBLIC.ASSETS_START_PATH").\Config::get("constants.FILE_PATH.BANNER");
      ?>
      <form action="{{route('admin.frontend-ui.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group" style="padding: 10px; border: 1px solid #ddd;margin-bottom: 30px">
          <h6><b>App</b></h6>
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* APP Logo</label>
                <input type="file" name="app_logo" class="form-control">
                <small class="text-danger">Recommended Image Size : 300px * 280px</small>
                @if($data)
                  <div class="current">
                    <div style="width: 150px; height: 100px;">
                      <img src="{{$logoLocation.$data->app_logo}}" width="100%" height="100%">
                    </div>
                  </div>
                @endif
              </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* APP Title</label>
                <input type="text" name="app_title" class="form-control" placeholder="App Title"
                value="@if($data){{$data->app_title}}@endif">
              </div>
            </div>
          </div>
        </div>

        <div class="form-group" style="padding: 10px; border: 1px solid #ddd;margin-bottom: 30px">
          <h6><b>Home</b></h6>
          <div class="row">

            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="form-group">
                <label>Home Banner Title</label>
                <input type="text" name="home_banner_title" class="form-control"
                value="@if($data){{$data->home_banner_title}}@endif">
              </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="form-group">
                <label>Home Banner Title Color</label>
                <input type="color" name="home_banner_title_color" class="form-control"
                value="@if($data){{$data->home_banner_title_color}}@endif">
              </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="form-group">
                <label>Home Banner Description</label>
                <input type="text" name="home_banner_description" class="form-control"
                value="@if($data){{$data->home_banner_description}}@endif">
              </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="form-group">
                <label>Home Banner Description Color</label>
                <input type="color" name="home_banner_description_color" class="form-control"
                value="@if($data){{$data->home_banner_description_color}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Search Box BG Color</label>
                <input type="color" name="search_box_bg_color" class="form-control"
                value="@if($data){{$data->search_box_bg_color}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Search Box Text</label>
                <input type="text" name="search_box_text" class="form-control"
                value="@if($data){{$data->search_box_text}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Search Box Text Color</label>
                <input type="color" name="search_box_text_color" class="form-control"
                value="@if($data){{$data->search_box_text_color}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Search Button Text</label>
                <input type="text" name="search_button_text" class="form-control"
                value="@if($data){{$data->search_button_text}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Search Button Text Color</label>
                <input type="color" name="search_button_text_color" class="form-control"
                value="@if($data){{$data->search_button_text_color}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Search Button BG Color</label>
                <input type="color" name="search_button_bg_color" class="form-control"
                value="@if($data){{$data->search_button_bg_color}}@endif">
              </div>
            </div>


          </div>
        </div>

        <div class="form-group" style="padding: 10px; border: 1px solid #ddd;margin-bottom: 30px">
          <h6><b>Easy 2 Step Order</b></h6>
          <div class="row">

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Left Title</label>
                <input type="text" name="easy_2_step_left_title" class="form-control"
                value="@if($data){{$data->easy_2_step_left_title}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Left Title Color</label>
                <input type="color" name="easy_2_step_left_title_color" class="form-control"
                value="@if($data){{$data->easy_2_step_left_title_color}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Left Description</label>
                <input type="text" name="easy_2_step_left_description" class="form-control"
                value="@if($data){{$data->easy_2_step_left_description}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Left Description Color</label>
                <input type="color" name="easy_2_step_left_description_color" class="form-control"
                value="@if($data){{$data->easy_2_step_left_description_color}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Right Title</label>
                <input type="text" name="easy_2_step_right_title" class="form-control"
                value="@if($data){{$data->easy_2_step_right_title}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Right Title Color</label>
                <input type="color" name="easy_2_step_right_title_color" class="form-control"
                value="@if($data){{$data->easy_2_step_right_title_color}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Right Description</label>
                <input type="text" name="easy_2_step_right_description" class="form-control"
                value="@if($data){{$data->easy_2_step_right_description}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Right Description Color</label>
                <input type="color" name="easy_2_step_right_description_color" class="form-control"
                value="@if($data){{$data->easy_2_step_right_description_color}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Small Text</label>
                <input type="text" name="easy_2_step_small_text" class="form-control"
                value="@if($data){{$data->easy_2_step_small_text}}@endif">
              </div>
            </div>


          </div>
        </div>

        <div class="form-group" style="padding: 10px; border: 1px solid #ddd;margin-bottom: 30px">
          <h6><b>App Section</b></h6>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* App Section BG Color</label>
                <input type="color" name="app_section_bg_color" class="form-control"
                value="@if($data){{$data->app_section_bg_color}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* App Section Title</label>
                <input type="text" name="app_section_title" class="form-control"
                value="@if($data){{$data->app_section_title}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* App Section Title Color</label>
                <input type="color" name="app_section_title_color" class="form-control"
                value="@if($data){{$data->app_section_title_color}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* App Section Description</label>
                <input type="text" name="app_section_description" class="form-control"
                value="@if($data){{$data->app_section_description}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* App Section Description Color</label>
                <input type="color" name="app_section_description_color" class="form-control"
                value="@if($data){{$data->app_section_description_color}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>Play Store APP ID Link</label>
                <input type="url" name="play_store_app_link" class="form-control"
                value="@if($data){{$data->play_store_app_link}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>Apple APP ID Link</label>
                <input type="url" name="apple_app_link" class="form-control"
                value="@if($data){{$data->apple_app_link}}@endif">
              </div>
            </div>

          </div>
        </div>

        <div class="form-group" style="padding: 10px; border: 1px solid #ddd;margin-bottom: 30px">
          <h6><b>Footer</b></h6>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Footer BG Color</label>
                <input type="color" name="footer_bg_color" class="form-control"
                value="@if($data){{$data->footer_bg_color}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>Facebook ULR</label>
                <input type="url" name="facebook_url" class="form-control"
                value="@if($data){{$data->facebook_url}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>Twitter ULR</label>
                <input type="url" name="twitter_url" class="form-control"
                value="@if($data){{$data->twitter_url}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>LinkedIn ULR</label>
                <input type="url" name="linkedIn_url" class="form-control"
                value="@if($data){{$data->linkedIn_url}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>Youtube ULR</label>
                <input type="url" name="youtube_url" class="form-control"
                value="@if($data){{$data->youtube_url}}@endif">
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label>Instagram ULR</label>
                <input type="url" name="instagram_url" class="form-control"
                value="@if($data){{$data->instagram_url}}@endif">
              </div>
            </div>

          </div>
        </div>


        <div class="form-group" style="padding: 10px; border: 1px solid #ddd;margin-bottom: 30px">
          <h6><b>Popup</b></h6>
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Signin Image</label>
                <input type="file" name="singin_image" class="form-control">
                <small class="text-danger">Recommended Image Size 292px * 350px & type .png</small>
                @if($data)
                  <div class="current">
                    <div style="width: 100px; height: 130px;">
                      <img src="{{$iconLocation.$data->singin_image}}" width="100%" height="100%">
                    </div>
                  </div>
                @endif
              </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Signup Image</label>
                <input type="file" name="signup_image" class="form-control">
                <small class="text-danger">Recommended Image Size 292px * 350px & type .png</small>
                @if($data)
                  <div class="current">
                    <div style="width: 100px; height: 130px;">
                      <img src="{{$iconLocation.$data->signup_image}}" width="100%" height="100%">
                    </div>
                  </div>
                @endif
              </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Reservation Image</label>
                <input type="file" name="reservation_image" class="form-control">
                <small class="text-danger">Recommended Image Size 292px * 350px & type .png</small>
                @if($data)
                  <div class="current">
                    <div style="width: 100px; height: 130px;">
                      <img src="{{$iconLocation.$data->reservation_image}}" width="100%" height="100%">
                    </div>
                  </div>
                @endif
              </div>
            </div>

          </div>
        </div>


        <div class="form-group" style="padding: 10px; border: 1px solid #ddd;margin-bottom: 30px">
          <h6><b>App Contact</b></h6>
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Contact Email</label>
                <input type="email" name="contact_email" class="form-control"
                value="@if($data){{$data->contact_email}}@endif">
                <small class="text-danger">The email where customers/web visitors can contact to administrator.</small>
              </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="form-group">
                <label>Contact Phone</label>
                <input type="text" name="contact_phone" class="form-control"
                value="@if($data){{$data->contact_phone}}@endif">
                <small class="text-danger">The phone number where customers/web visitors can contact to administrator.</small>
              </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="form-group">
                <label>Contact Address</label>
                <input type="text" name="contact_address" class="form-control"
                value="@if($data){{$data->contact_address}}@endif">
                <small class="text-danger">Note : For new line use ##,</small>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-primary btn-sm" type="submit">Submit</button>
      </form>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

@endsection
