@extends('backendViews.layouts.app')

@push("styles")
<style type="text/css">
  .size-options label{
    width: 100px;
    text-align: center;
    border: 1px solid #ddd;
    padding: 5px;
    border-radius: 3px;
    text-transform: uppercase;
    cursor: pointer;
  }
  .size-options label.size_active{
    background: forestgreen;
    color: #fff;
  }
</style>
@endpush


@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Edit Product<small class="ml-3 mr-3">|</small><small>Create</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a>
          </li>
          <li class="breadcrumb-item active">Edit</li>
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
          <a class="nav-link" href="{{route('admin.products.index')}}"><i class="fa fa-list mr-2"></i>Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-pencil mr-2"></i>Edit</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      
      <form id="productUpdateForm" action="{{route('admin.products.update', encrypt($product->id))}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <div class="form-group">
          <label>* Type</label>
          <select readonly class="form-control" name="type">
            <option value="">Select</option>
            <option @if($product->type === 'Main') selected @endif value="Main">Main</option>
            <option @if($product->type === 'Staff') selected @endif value="Staff">Staff</option>
          </select>
        </div>

        <div class="form-group @if($product->type !== 'Staff') d-none @endif" id="itemTypeOption">
          <label>* Item/Product Type</label>
          <select class="form-control" name="item_type">
            <option @if($product->item_type === 'Product') selected @endif value="Product">Product</option>
            <option @if($product->item_type === 'Meal') selected @endif value="Meal">Meal</option>
          </select>
        </div>

        <div class="form-group">
          <label>* Category/Menu</label>
          <div id="categories">
            @include("backendViews.products.partials.categories")
          </div>
        </div>


        <div class="form-group">
          <label>* Product Title</label>
          <input type="text" name="title" placeholder="Title (max {{\Config::get('constants.PRODUCT.TITLE_LENGTH')}} characters)"  class="form-control" value="{{$product->title}}">
        </div>

        <div class="form-group">
          <label>* Description</label>
          <textarea class="form-control" name="description" rows="10" class="10" placeholder="Description (max {{\Config::get('constants.PRODUCT.DESCRIPTION_LENGTH')}} characters)">{!! $product->description !!}</textarea>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="form-group">
                <label>* Price ({{env('CURRENCY_SYMBOL')}})</label>
                <input type="number" name="price" class="form-control" placeholder="Price" step="0.01" value="{{$product->price}}">
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12" id="discount_blcok">
              <div class="form-group">
                <label>Discount Price ({{env('CURRENCY_SYMBOL')}})</label>
                <input type="number" name="discount_price" class="form-control" placeholder="Discount Price" step="0.01" value="{{$product->discount_price}}">
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>New Images</label>
          <input type="file" name="images[]" class="form-control" multiple="1" accept="images/*">
          <small class="text-danger">At least one image is required</small>
        </div>

        <div class="form-group">
          <label>Current Images</label>
          <div class="row">
            <?php
              foreach (json_decode($product->images, true) as $key => $image) {
                $img = \Config::get("constants.PUBLIC.ASSETS_START_PATH").\Config::get("constants.FILE_PATH.PRODUCT").$image;
                echo "<div class='col-lg-3 col-md-4 col-sm-12'>";
                  echo "<div class='p-3' style='border:1px solid #ddd'>";
                    echo "<img src='".$img."' style='width:100%;max-height:100%'>";
                  echo "</div>";
                echo "</div>";
              }
            ?>
          </div>
        </div>

        <div class="form-group" style="padding: 10px; border: 1px solid #ddd">
          
          <div class="d-flex justify-content-between">
            <label>Add Specifications <small>(Optional)</small></label>
            <button class="btn btn-warning btn-sm" type="button" id="add_field_btn">Add</button>  
          </div>

          <div>
            @include("backendViews.products.partials.specifications")
          </div>
        </div>

        <div class="form-group">
          <label>* Size</label>
          <div class="size-options">
            <label for="sizeLarge" class="first_ @if($product->size === 'large') size_active @endif ">Large</label>
            <label for="sizeSmall" class="second_ @if($product->size === 'small') size_active @endif ">Small</label>
          </div>
          <input id="sizeLarge" type="radio" name="size" value="large" class="d-none" @if($product->size === 'large') checked @endif > 
          <input id="sizeSmall" type="radio" name="size" value="small" class="d-none" @if($product->size === 'small') checked @endif > 
        </div>

        <div class="form-group">
          <label>Note <small>(optional)</small></label>
          <textarea class="form-control" name="note" rows="3" class="10" placeholder="Note (max {{\Config::get('constants.PRODUCT.NOTE_STRING_MAX')}} characters)">{!! $product->note !!}</textarea>
        </div>
        
        <div class="form-group">
          <label>* Status</label>
          <select class="form-control" name="status">
            <option @if($product->status === 'Active') selected @endif value="Active">Active</option>
            <option @if($product->status === 'Inactive') selected @endif value="Inactive">Inactive</option>
          </select>
          <small class="text-danger">Note : Once you inactive product then the product will not availabe in frontend until you active.</small>
        </div>
        <button class="btn btn-primary btn-sm" type="submit">Update</button>
      </form>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

@endsection

@push("scripts")
<script type="text/javascript">
  $(document).ready(function(){
    getCategories($("form select[name='type']").val())
  })

  function getCategories(type){
    if (type == '') {
      $("form select[name='category']").html("")
    }
    if (type === "Staff") {
      $("#itemTypeOption").removeClass("d-none")

      //hide discount - discount not applicable for product
      $("#discount_blcok").addClass("d-none")
    }else{
      $("#itemTypeOption").addClass("d-none")

      //show discount
      $("#discount_blcok").removeClass("d-none")
    }

    $.ajax({
      url:"/admin/get_categories_type_wise?type="+type+"&current_category={{$product->category_id}}",
      dataType:"HTML",
      cache:false,
      beforeSend:function(){
        $("#categories").html("")
      },
      success:function(response){
        $("#categories").html(response)
      },
      error:function(){
        $("#categories").html("")
        console.log("something wrong...")
      },
      complete:function(){

      }
    })
  }  
</script>


<script type="text/javascript">
  $("form input[name='size']").on("click", function(){
    let value = $(this).val()
    $("div.size-options label").removeClass("size_active")

    if (value === "large") {
      $("div.size-options label.first_").addClass("size_active")
      return;
    }else{
      $("div.size-options label.second_").addClass("size_active")
      return;
    }
  })
</script>

<script type="text/javascript">
   $("form#productUpdateForm").on('submit', function(e){
         e.preventDefault();
         var form = $(this);
         var url = form.attr('action');
         var type = form.attr('method');
         //var form_data = form.serialize();
   
         formSubmitWithFile("productUpdateForm", url, type);
     })
</script>
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/form_submitter/general-form-submit.js"></script>
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/sw_alert/sweetalert2@10.js"></script>
@endpush