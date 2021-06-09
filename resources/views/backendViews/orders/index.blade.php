@extends('backendViews.layouts.app')

@push("styles")
<style type="text/css">
  .checkout-page .checkout-heading{
    text-align: center;
    text-transform: uppercase;
    padding: 10px;
    margin: 30px 0px 0px 0px;
    border-bottom: 1px solid #ddd;
  }
  .checkout-page table.checkout-tbl thead{
    background-color: #efefef
  }

  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }


  /*design qty control buttons*/
  .checkout-page .qty button{
    background: transparent;
    border: 1px solid #ddd;
    padding: 0;
    width: 25px;
    height: 25px;
    font-size: 14px;
    border-radius: 50%;
  }
  .checkout-page .qty div{
    margin: 0px 5px
  }



  .checkout-page input.coupon_code_input{
    padding: 2px 5px;
    border: 1px dashed #ddd;
    border-radius: 3px;
    outline: none;
  }
  .checkout-page button#apply_coupon_code_btn{
    width: 100%;
    border: 1px solid forestgreen;
    background: #dc4e1c;
    color: #fff;
    text-transform: uppercase;
    padding: 5px;
    border-radius: 3px;
    margin-top: 8px;
    outline: none;
  }
  .checkout-page td.remove_borders{
    border: none !important;
  }

  .checkout-page  tr.special_tr{
    background-color: #FBFAF1 !important
  }
  .checkout-page  table tr th,
  .checkout-page  table tr td{
    padding: 0
  }
  .checkout-page  tr.special_tr th,
  .checkout-page  tr.special_tr td{
    padding: 0
  }

  .checkout-page  .address_options div:nth-child(1){
    width: 60%
  }
  .checkout-page  .address_options div:nth-child(2){
    width: 40%
  }
  .checkout-page  .address_options div:nth-child(2) button{
    width: 100%;
    margin: 25px 0;
    padding: 5px 10px;
    border-radius: 3px;
    border: 1px dashed #ddd;
    outline: none;
  }

  .checkout-page  select.address{
    width: 100%;
    margin: 25px 0;
    padding: 5px 10px;
    border-radius: 3px;
    border: 1px dashed #ddd;
    outline: none;
  }

  .checkout-page .proceed_next_link{
    width: 100%;
    display: block;
    text-align: center;
    background: #dc4e1c;
    padding: 5px;
    border-radius: 3px;
    color: #fff;
    text-decoration: none;
  }

  .form-group{
    margin-bottom: 15px
  }


  .encourage_block th{
    color: #dc4e1c
  }
  .encourage_block th,
  .encourage_block td
  {
    margin-bottom: 7px
  }

  .payment_gateway{
    padding: 20px;
    border-right: 1px solid #ddd;
    margin: 10px;
    padding-right: 60px
  }
  .encourage_block{
    padding: 15px;
    margin: 10px;
  }


  button.paymentOptionsBTN{
    width: 200px;
    border: none;
    outline: none;
    padding: 10px;
    background-color: transparent;
    border: 1px dashed #ddd;
  }
  button.activePaymentOption{
    background-color: #dc4e1c;
    color: #fff;
    border:1px solid #dc4e1c;
  }
  button.paymentOptionsBTN:hover{
    background: transparent;
    color: #dc4e1c;
    border: 1px dashed #dc4e1c;
  }
  textarea {
    resize: none;
    outline: none;
    padding: 0;
    margin: 0;
    font-size: 12px
  }

  .parent--heading{
    font-size: 20px;
  }
  .sub--heading{
    font-size: 12px;
    margin-top: 5px;
    font-weight: bold;
  }

  table tbody#render__data tr{
    padding: 10px;
    border:1px solid #ddd
  }
  .checkout-page table tbody tr{
    padding: 0 !important;
    border:none !important;
  }
  table tr:hover{
    background: #F1F3F6 !important;
    box-shadow: 0 2px 4px 0 rgb(0 0 0 / 8%);
  }

  div.top-actions-bar{
    margin-bottom: 15px
  }
  div.top-actions-bar input,
  div.top-actions-bar select{
    border: 1px solid #ddd;
    padding: 3px 10px;
    border-radius: 3px;
    margin-right: 3px;
    font-size: 12px;
    outline: none;
  }


  /*pagination design*/
  .pagination{
    justify-content:center;
  }
  .pagination li span.page-link{
    border-radius: 70px !important;
    font-size: 12px;
    line-height: 1;
    margin: 0 3px;
    width: 32px;
    height: 32px;
    text-align: center;
    padding: 10px 12px;
  }
</style>
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Orders<small class="ml-3 mr-3">|</small><small>Orders Management</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="">Orders</a>
          </li>
          <li class="breadcrumb-item active">Orders</li>
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
    $activeNav = "index";
    if (\Request::get('type') == '') {
      $activeNav = "index";
    }else{
      $activeNav = \Request::get('type');
    }
  ?>
  <div class="card">
    <div class="card-header">
      <div class="notifications-area text-center">
        <img src="{{$publicAssetsPathStart}}plugins/processing_gif/live.gif" width="30px"> <span style="font-size: 12px">Live updating</span>
        <br>
        <div class="display--live--msg"></div>
      </div>

      <ul class="nav nav-tabs align-items-end card-header-tabs w-100" style="justify-content: space-around">
        <li class="nav-item">
          <a class="nav-link @if($activeNav === 'New') active @endif" href="{{route('admin.orders.index')}}?type=New"><i class="fa fa-plus mr-2"></i>New</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if($activeNav === 'In Progress') active @endif" href="{{route('admin.orders.index')}}?type=In Progress"><i class="fa fa-undo mr-2"></i>In Progress</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if($activeNav === 'Out For Delivery') active @endif" href="{{route('admin.orders.index')}}?type=Out For Delivery"><i class="fa fa-truck mr-2"></i>Out For Delivery</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if($activeNav === 'Cancelled') active @endif" href="{{route('admin.orders.index')}}?type=Cancelled"><i class="fa fa-times mr-2"></i>Cancelled</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if($activeNav === 'Completed') active @endif" href="{{route('admin.orders.index')}}?type=Completed"><i class="fa fa-check mr-2"></i>Completed</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if($activeNav === 'index') active @endif" href="{{route('admin.orders.index')}}"><i class="fa fa-star mr-2"></i>All</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <div class="d-flex justify-content-center top-actions-bar">
          <input type="text" id="searchKey__" placeholder="Search Order ID, Email, Phone, Name, Post Code, Code">
          <select id="selected_row_per_page">
            <option value="5">Per Page 5</option>
            <option value="10">Per Page 10</option>
            <option value="15">Per Page 15</option>
            <option value="20">Per Page 20</option>
            <option value="30">Per Page 30</option>
          </select>

          <select id="hidden__sorting_order">
            <option value="DESC">Newest</option>
            <option value="ASC">Oldest</option>
          </select>
        </div>

        <table class="table dataTable" width="100%" style="width: 100%;">
         <tbody id="render__data">
          @include("backendViews.orders.partials.new-list")
         </tbody>
        </table>

        <input type="hidden" id="hidden__action_url" value="{{ route('admin.ordersDatatableCustom.data') }}">
        <input type="hidden" id="hidden__page_number" value="1">
        <input type="hidden" id="hidden__sort_by" value="created_at">
        <input type="hidden" id="hidden__status" value="{{$activeNav}}">
        <input type="hidden" id="hidden__id" value="">
        <input type="hidden" id="hidden_paramters__one" value="">
        <input type="hidden" id="hidden_paramters__two" value="">
        <input type="hidden" id="hidden_paramters__three" value="">
        <input type="hidden" id="hidden_paramters__four" value="">
        <input type="hidden" id="hidden_paramters__five" value="">

      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
@endsection


@push("scripts")
<!-- datatable scripts -->
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/custom_datatables/datatables.js"></script>

<script type="text/javascript">

  $(document).ready(function(){
    setInterval(function() {
       liveUpdateOrdersData()
     }, "{{Config::get('constants.ORDER.LIVE_UPDATE_EVERY')}}");
  })


  function liveUpdateOrdersData(){
    let action_url = $("#hidden__action_url").val()
        let searchKey = $("#searchKey__").val()
        let pageNumber = 1;
        let sort_by = $("#hidden__sort_by").val()
        let sorting_order = $("#hidden__sorting_order").val()
        let hidden__status = $("#hidden__status").val()
        let row_per_page = $("#selected_row_per_page").val()
        let hidden__id = $("#hidden__id").val()
        
        let param_1 = $("#hidden_paramters__one").val()
        let param_2 = $("#hidden_paramters__two").val()
        let param_3 = $("#hidden_paramters__three").val()
        let param_4 = $("#hidden_paramters__four").val()
        let param_5 = $("#hidden_paramters__five").val()
        fetch_paginate_data(action_url, pageNumber, searchKey, sort_by, sorting_order, hidden__status, row_per_page, hidden__id, param_1, param_2, param_3, param_4, param_5);
  }
</script>
@endpush

