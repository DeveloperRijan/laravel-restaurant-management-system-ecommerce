@extends('backendViews.layouts.app')

<link rel="stylesheet" href="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net-bs4/css/dataTables.bootstrap4.css" >

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Base PostCodes<small class="ml-3 mr-3">|</small><small>Management</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">PostCodes</a>
          </li>
          <li class="breadcrumb-item active">PostCodes</li>
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
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>PostCodes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="" type="button" data-toggle="modal" data-target="#addNewPostCode" ><i class="fa fa-plus mr-2"></i>Config</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="datatable__tbl" class="table dataTable" width="100%" style="width: 100%;">
         <thead>
            <tr role="row">
               <th>Base PostCode</th>
               <th>Radius Distance In KM</th>
               <th>Updated at</th>
            </tr>
         </thead>
         <tbody>
          @if($data)
            <tr role="row">
               <td>{{$data->post_code}}</td>
               <td>{{$data->radius_distance_km}}</td>
               <td>
                  <small>
                    @if($data->updated_at != null)
                    {{$data->updated_at->format(env('GENERAL_DATE_FORMAT'))}}
                    @endif
                  </small>
               </td>
            </tr>
          @else
          <tr>
            <td colspan="10">No Data Found</td>
          </tr>
          @endif
           
         </tbody>
        </table>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="addNewPostCode" tabindex="-1" aria-labelledby="addNewPostCodeLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addNewPostCodeLabel">Add New</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('admin.postcodes.store')}}" method="POST">
          @csrf
          <div class="form-group">
            <label>Base PostCode</label>
            @if($data)
            <input value="{{$data->post_code}}" type="text" name="post_code" placeholder="Base PostCode" class="form-control" required="1" maxlength="99">
            @else
            <input type="text" name="post_code" placeholder="Base PostCode" class="form-control" required="1" maxlength="99">
            @endif
          </div>

          <div class="form-group">
            <label>Base Radius Distance in KM</label>
            @if($data)
            <input value="{{$data->radius_distance_km}}" type="number" name="radius_distance_km" placeholder="Radius Distance in KM" required="1" class="form-control" min="1">
            @else
            <input type="number" name="radius_distance_km" placeholder="Radius Distance in KM" required="1" class="form-control" min="1">
            @endif
            <small>The base radius distance in km will be the standard to calculate the distance to determine of Collection/Delivery</small>
          </div>
          <button class="btn btn-primary btn-sm" type="submit">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection




