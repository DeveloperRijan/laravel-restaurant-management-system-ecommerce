@extends('backendViews.layouts.app')

<link rel="stylesheet" href="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net-bs4/css/dataTables.bootstrap4.css" >

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Sliders<small class="ml-3 mr-3">|</small><small>Sliders Management</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">Sliders</a>
          </li>
          <li class="breadcrumb-item active">Sliders</li>
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
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>Sliders</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="" type="button" data-toggle="modal" data-target="#sliderAddModal" ><i class="fa fa-plus mr-2"></i>Add New</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table dataTable text-center" width="100%" style="width: 100%;">
         <thead>
            <tr role="row">
               <th>SN</th>
               <th>Image</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
          @foreach($sliders as $key=>$slider)
            <tr role="row">
               <td>{{ $key+1}}</td>
               <td>
                 <img src="{{$publicAssetsPathStart.Config::get('constants.FILE_PATH.SLIDERS').$slider->image}}" style="width: 200px; max-height: 140px;">
               </td>
               <td>
                  <div class="btn-group btn-group-sm">
                     <a href="" class="btn btn-link"
                     type="button" data-toggle="modal" data-target="#editSliderModal-{{$slider->id}}">
                      <i class="fa fa-edit"></i>
                     </a>

                     <div class="modal fade" id="editSliderModal-{{$slider->id}}" tabindex="-1" aria-labelledby="editSliderModalLabel-{{$slider->id}}" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="editSliderModalLabel-{{$slider->id}}">Update Slider</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body text-left">
                            <form action="{{route('admin.sliders.update', $slider->id)}}" method="POST" enctype="multipart/form-data">
                              @csrf
                              @method("PUT")
                              <div class="form-group">
                                <label>Select Image</label>
                                <input type="file" name="image" class="form-control" required="1">
                                <small class="text-danger">Note : Recommended Image Size : 2500px * 1667px</small>
                              </div>
                              <button type="submit" class="btn btn-primary btn-sm">Update</button>          
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>



                     <a onclick="return confirm('Are you sure to DELETE?')" href="{{ route('admin.slider.actions', [encrypt($slider->id), 'Delete']) }}" class="btn btn-link">
                      <i class="fa fa-trash"></i>
                     </a>
                  </div>
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


<!-- Modal -->
<div class="modal fade" id="sliderAddModal" tabindex="-1" aria-labelledby="addNewPostCodeLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addNewPostCodeLabel">Add New</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('admin.sliders.store')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label>Select Image</label>
            <input type="file" name="image" class="form-control" required="1">
            <small class="text-danger">Note : Recommended Image Size : 2500px * 1667px</small>
          </div>
          <button type="submit" class="btn btn-primary btn-sm">Add</button>          
        </form>
      </div>
    </div>
  </div>
</div>

@endsection


