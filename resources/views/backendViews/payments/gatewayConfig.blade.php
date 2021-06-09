@extends('backendViews.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Payment Gateways<small class="ml-3 mr-3">|</small><small>Payment</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item active">Payments</li>
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
          <a class="nav-link active" href="{{route('admin.payment-gateway.index')}}"><i class="fa fa-list mr-2"></i>Payment Gateways</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="" type="button" data-toggle="modal" data-target="#gatewayConfigModal" ><i class="fa fa-gear mr-2"></i>Config</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      
      <div class="table-responsive">
        <table class="table">

          @if($data)
          <tr>
            <th>Gateway</th>
            <td>Paypal</td>
          </tr>

          <tr>
            <th>Is key Set</th>
            @if($data->client_id != '')
            <td><span class="badge badge-success">Yes</span></td>
            @else
            <td><span class="badge badge-danger">No</span></td>
            @endif
          </tr>

          <tr>
            <th>Last Modified</th>
            <td>
              @if($data->updated_at !== NULL)
                {{date(env("GENERAL_DATE_FORMAT"), strtotime($data->updated_at))}}
              @endif
            </td>
          </tr>

          @else
          <tr>
            <td colspan="2">No Data Found</td>
          </tr>
          @endif
        </table>
      </div>

      <div class="clearfix"></div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="gatewayConfigModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Paypal Payment Gateway</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <form action="{{route('admin.payment-gateway.store')}}" method="POST">
          @csrf
          <div class="form-group">
            <label>Paypal Client ID</label>
            <input type="text" name="client_id" class="form-control" autocomplete="off" placeholder="Paste your key here">
            <small class="text-danger">Note : If you enter sandbox client_id then payment mode will be sandbox else live.</small>
          </div>
          

          <button class="btn btn-primary btn-sm" type="submit">Save</button>
        </form>


      </div>
    </div>
  </div>
</div>

@endsection
