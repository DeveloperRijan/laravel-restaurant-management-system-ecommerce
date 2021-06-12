@extends('ks_panel.layouts.app')

@push("styles")

@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Support<small class="ml-3 mr-3">|</small><small>Management</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('ks.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">Support</a>
          </li>
          <li class="breadcrumb-item active">Support</li>
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
      <div class="notifications-area text-center">
        <img src="{{$publicAssetsPathStart}}plugins/processing_gif/live.gif" width="30px"> <span style="font-size: 12px">Live Support</span>
        <br>
        <div class="display--live--msg"></div>
      </div>

      <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
        <li class="nav-item">
          <a class="nav-link active" href=""><i class="fa fa-plus mr-2"></i>Open Tickets</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href=""><i class="fa fa-undo mr-2"></i>Archived</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      
      @include("components.chat.admin_chat")

      <div class="clearfix"></div>
    </div>
  </div>
</div>
@endsection


@push("scripts")
@endpush

