@extends('backendViews.layouts.app')

<link rel="stylesheet" href="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net-bs4/css/dataTables.bootstrap4.css" >

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Products<small class="ml-3 mr-3">|</small><small>Products Management</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">Products</a>
          </li>
          <li class="breadcrumb-item active">Products</li>
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
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('admin.products.create')}}"><i class="fa fa-plus mr-2"></i>Create Product/Item</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="datatable__tbl" class="table dataTable" width="100%" style="width: 100%;">
         <thead>
            <tr role="row">
               <th><small>SN</small></th>
               <th><small>Type</small></th>
               <th><small>Item Type</small></th>
               <th><small>Title</small></th>
               <th><small>Category</small></th>
               <th><small>Price</small></th>
               <th><small>Status</small></th>
               <th><small>Stock</small></th>
               <th><small>Created at</small></th>
               <th><small>Actions</small></th>
            </tr>
         </thead>
         <tbody>
          @foreach($data as $key=>$product)
            <tr role="row">
               <td><small>{{ $key+1}}</small></td>
               <td><small>{{$product->type}}</small></td>
               <td><small>{{$product->item_type}}</small></td>
               <td><small>{{$product->title}}</small></td>
               <td><small>{{$product->get_category->name}}</small></td>
               <td><small>{{env('CURRENCY_SYMBOL').$product->price}}</small></td>
               <td>
                 <span class="badge {{ ($product->status === 'Active' ? 'badge-success' : 'badge-danger') }}">{{$product->status}}</span>
               </td>
               <td>
                 <span class="badge {{ ($product->stock_status === 'Sold Out' ? 'badge-warning' : 'badge-info') }}">{{$product->stock_status}}</span>
               </td>
               <td>
                  <small>
                    {{$product->created_at->format(env('GENERAL_DATE_FORMAT'))}}
                  </small>
               </td>
               <td>
                  <div class="btn-group btn-group-sm">
                     <a href="{{route('admin.products.edit', encrypt($product->id))}}" class="btn btn-link">
                     <i class="fa fa-edit"></i>
                     </a>

                     @if($product->stock_status === "Sold Out")
                     <a class="text-success" onclick="return confirm('Are you sure to mark as Available?')" href="{{route('admin.product.action', [encrypt($product->id), encrypt('Available')])}}" class="btn btn-link">
                      <i class="fa fa-outdent"></i>
                     </a>
                     @else
                      <a class="text-warning" onclick="return confirm('Are you sure to mark as Sold Out?')" href="{{route('admin.product.action', [encrypt($product->id), encrypt('Sold Out')])}}" class="btn btn-link">
                        <i class="fa fa-outdent"></i>
                      </a>
                     @endif

                     <a onclick="return confirm('Are you sure to DELETE?\nRemember : The action will not be revert!')" href="{{route('admin.product.action', [encrypt($product->id), encrypt('SoftDelete')])}}" class="btn btn-link">
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
@endsection


@push("scripts")
<!-- datatable scripts -->
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/config_js/datatable_config.js"></script>
@endpush

