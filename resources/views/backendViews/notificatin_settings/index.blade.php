@extends('backendViews.layouts.app')

<link rel="stylesheet" href="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net-bs4/css/dataTables.bootstrap4.css" >

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Notifications<small class="ml-3 mr-3">|</small><small>Settings</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">Notifications</a>
          </li>
          <li class="breadcrumb-item active">Settings</li>
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
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>Settings</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <p><i class="fa fa-info-circle"></i> Setting your orders processing notifications mode...</p>
      
        <div class="table-responsive">
          <table class="table dataTable" width="100%" style="width: 100%;">
           
           <tbody>
            @foreach($data as $key=>$row)
              <tr role="row">

                 <td>
                  <form action="{{route('admin.notification-settings.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$row->id}}">
                    <div class="d-flex justify-content-between">
                      <div style="width: 25%">
                        {{$row->type}}
                      </div>
                      <div style="width: 25%">
                        {{$row->context}}
                      </div>
                      <div style="width: 25%">
                        <select name="notification_mode" style="border: 1px solid #ddd; padding: 3px 5px; outline: none; width: 100%">
                          <?php
                            foreach (\Config::get("constants.ORDER_NOTIFICATIONS.MODES") as $key => $mode) {
                              if ($row->notification_mode === $mode) {
                                echo "<option selected value='".$row->notification_mode."'>".$row->notification_mode."</option>";
                              }else{
                                echo "<option value='".$mode."'>".$mode."</option>";
                              }
                            }
                          ?>
                        </select>
                      </div>
                      <div style="width: 25%;text-align: right;">
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                      </div>
                    </div>
                  </form>
                 </td>

              </tr>
            @endforeach
             
           </tbody>
          </table>
        </div>

      <div class="clearfix"></div>
    </div>
  </div>
</div>

@endsection


