@extends('backendViews.layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">{{$user->type}}<small class="ml-3 mr-3">|</small><small>Details</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">{{$user->type}}</a>
          </li>
          <li class="breadcrumb-item active">Details</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">
  <div class="clearfix"></div>
  @include("msg.msg")

  <?php
    $navigationTo = NULL;
    if ($user->type === "Customer") {
      $navigationTo = "customers";
    }elseif ($user->type === "Staff") {
      $navigationTo = "staffs";
    }elseif ($user->type === "Kitchen Staff") {
      $navigationTo = "kitchen_staffs";
    }
  ?>

  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
        <li class="nav-item">
          <a class="nav-link" href="{{route('admin.users.index')}}?type={{$navigationTo}}"><i class="fa fa-list mr-2"></i>{{$user->type}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="">Details</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="d-flex justify-content-end">
          @if($user->type !== "Customer")

            @if($user->type === "Staff")
              <div>
                <a class="btn btn-info btn-sm mr-1" href="{{route('admin.users.edit', encrypt($user->id))}}" class="btn btn-link">
                  <i class="fa fa-edit"></i>
                </a>
              </div>
            @endif

            @if($user->type === "Kitchen Staff")
              <div>
                <a class="btn btn-info btn-sm mr-1" href="{{route('admin.edit.kitchen.staff.get', encrypt($user->id))}}" class="btn btn-link">
                  <i class="fa fa-edit"></i>
                </a>
              </div>
            @endif
          @endif

          @if($user->type === "Staff")
            @if($user->status === "Pending")
              <div>
                <a class="btn btn-success btn-sm mr-1" onclick="return confirm('Are you sure to active account?')" title="Activate the staff account" href="{{route('admin.user.actions', [encrypt($user->id), encrypt('Active')] )}}" class="btn btn-link">
                  <i class="fa fa-check"></i>
                </a>
              </div>
            @endif
          @endif

          @if($user->deleted_at != NULL)
          <div>
            <a class="btn btn-success btn-sm mr-1" title="Restore the user" onclick="return confirm('Are you sure to UNBLOCK?')" href="{{route('admin.user.actions', [encrypt($user->id), encrypt('Unblock')])}}" class="btn btn-link">
              <i class="fa fa-undo"></i>
            </a>
          </div>
          @else
          <div>
            <a class="btn btn-warning btn-sm mr-1" onclick="return confirm('Are you sure to BLOCK?\nRemember : Once you block this user, then can not login anymore until you unblock!')" href="{{route('admin.user.actions', [encrypt($user->id), encrypt('SoftDelete')])}}" class="btn btn-link">
              <i class="fa fa-trash"></i>
            </a>
          </div>
          @endif
      </div>

      <div class="table-responsive">
        <table class="table dataTable" width="100%" style="width: 100%;">
          <tbody>
            <tr>
              <th><small>Status</small></th>
              @if($user->delete_at != null)
                <td>
                  <small><span class="badge badge-warning">Blocked</span></small>
                </td>
              @else
                <td>
                  <small>
                    <span class="badge badge-info">{{$user->status}}</span>
                  </small>
                </td>
              @endif
            </tr>
            <tr>
              <th><small>Name</small></th>
              <td><small>{{$user->name}}</small></td>
            </tr>
            <tr>
              <th><small>Email</small></th>
              <td><small>{{$user->email}}</small></td>
            </tr>
            <tr>
              <th><small>Phone</small></th>
              <td>
                <small>{{$user->phone}}</small>
              </td>
            </tr>

            @if($user->type === "Staff")
              <tr>
                <th><small>Company Name</small></th>
                <td><small>{{$user->company_name }}</small></td>
              </tr> 
              <tr>
                <th><small>Code</small></th>
                <td><small>{{$user->code }}</small></td>
              </tr>
              <tr>
                <th><small>Address line one</small></th>
                <td><small>{{$user->address_line_one }}</small></td>
              </tr>
              <tr>
                <th><small>Address line two</small></th>
                <td><small>{{$user->address_line_two }}</small></td>
              </tr> 
              <tr>
                <th><small>City</small></th>
                <td><small>{{$user->city }}</small></td>
              </tr>
              <tr>
                <th><small>State</small></th>
                <td><small>{{$user->state }}</small></td>
              </tr>
              <tr>
                <th><small>Post Code</small></th>
                <td><small>{{$user->post_code }}</small></td>
              </tr>

              <tr>
                <th><small>Company Allocated Hrs</small></th>
                @if($user->can_order_any_time === "Yes")
                <td>
                  <small>Can Order Anytime</small>
                </td>
                @else
                <td>
                  <small>
                    {{ date(env("TIME_TO_FORMAT"), strtotime($user->start_time)) }} to {{ date(env("TIME_TO_FORMAT"), strtotime($user->end_time)) }}<br>
                    {{$user->start_day }} to {{$user->end_day }}
                  </small>
                </td>
                @endif
              </tr>

              <tr>
                <th><small>Designation</small></th>
                <td>
                  @if($user->get_designation)
                    <small>{{$user->get_designation->title}}</small>
                  @else
                    <small><span title="Designation Not Found">N/A</span></small>
                  @endif
                </td>
              </tr>         
            @endif
            
            <tr>
              <th><small>Registration Date</small></th>
              <td>
                <small>{{$user->created_at->format(env('GENERAL_DATE_FORMAT'))}}</small>
              </td>
            </tr>
          </tbody>
         
        </table>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
@endsection


