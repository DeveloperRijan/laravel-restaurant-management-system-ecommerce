@extends('backendViews.layouts.app')


@section('content')
	<section>
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="card-body">
					  <h4 style="font-size: 16px">Recent Orders</h4>
				      <div class="table-responsive">
				        <table class="table" width="100%" style="width: 100%;">
				         <thead style="background:#efefef">
				            <tr role="row">
				               <th><small>Order By</small></th>
				               <th><small>Order ID</small></th>
				               <th><small>Payment Type</small></th>
				               <th><small>Order Date</small></th>
				            </tr>
				         </thead>
				         <tbody>
				          @foreach($recentOrders as $key=>$order)

					            <tr role="row">
					               <td><small>{{$order->order_by}}</small></td>
					               <td><small>#<a href="{{route('admin.orders.show', encrypt($order->id))}}">{{$order->order_id}}</a></small></td>
					               <td><small>{{$order->payment_type}}</small></td>
					               <td>
					                  <small>
					                    {{$order->created_at->format(env('GENERAL_DATE_FORMAT'))}}
					                  </small>
					               </td>
					            </tr>

				          @endforeach
				           
				         </tbody>
				        </table>
				      </div>
				      <div class="clearfix"></div>
				    </div>
				</div>

				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="card-body">
						<h4 style="font-size: 16px">Recent Items/Products</h4>
				      <div class="table-responsive">
				        <table class="table dataTable" width="100%" style="width: 100%;">
				         <thead style="background:#efefef">
				            <tr role="row">
				               <th><small>Title</small></th>
				               <th><small>Category</small></th>
				               <th><small>Price</small></th>
				               <th><small>Created at</small></th>
				            </tr>
				         </thead>
				         <tbody>
				          @foreach($recentItems as $key=>$product)
				            <tr role="row">
				               <td><small><a href="{{route('admin.products.edit', encrypt($product->id))}}">{{$product->title}}</a></small></td>
				               <td><small>{{$product->get_category->name}}</small></td>
				               <td><small>{{env('CURRENCY_SYMBOL').$product->price}}</small></td>
				               <td>
				                  <small>
				                    {{$product->created_at->format(env('GENERAL_DATE_FORMAT'))}}
				                  </small>
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
		</div>
	</section>
@endsection