@extends("frontendViews.layouts.master")

@push("styles")
<link rel="stylesheet" href="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net-bs4/css/dataTables.bootstrap4.css" >
<style type="text/css">
   body{
      background: #ddd !important
   }
   div.fixed{
      background: #000 !important
   }
</style>
@endpush

@section("content")

      <section class="main-block light-bg account-section">
         <div class="container">
            <div class="row">
              <div class="col-lg-12 col-md-6 col-sm-12">
                @include("msg.msg")

                @if(\Session::has("orderStatusSuccess"))
                  <div class="alert alert-success text-center" role="alert">
                    <span style="font-size: 30px"><i class="fas fa-info-circle"></i></span> <br>
                    Your Order has been successfully placed! <br>
                    Thank You <br>
                    Your Order ID : #{{\Session::get("orderStatusSuccess")}}
                  </div>
                @endif
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-md-4 col-sm-12 left_part">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <a href="{{route('customer.account.get')}}?data=profile" class="nav-link @if(\Request::get('data') === 'profile' || \Request::get('data') === 'password') active @endif ">Profile</a>
                  <a href="{{route('customer.account.get')}}?data=orders" class="nav-link @if(\Request::get('data') === 'orders') active @endif ">Orders</a>
                  {{--
                  <a href="{{route('customer.account.get')}}?data=reservations" class="nav-link @if(\Request::get('data') === 'reservations') active @endif ">Reservations</a>
                  --}}
                  
                  <a href="" class="nav-link" aria-selected="false"
                     onclick="event.preventDefault();
                     document.getElementById('logout---form').submit();"
                  >
                  Logout
                  </a>
                  <form id="logout---form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
                </div>
              </div>
              <div class="col-lg-9 col-md-8 col-sm-12 right_part">
                <div class="tab-content" id="v-pills-tabContent">
                  @if(\Request::get('data') === "orders")
                  <div class="tab-pane fade show active">
                    @if(\Request::get('id') == '')
                      @include("frontendViews.user.account.partials.orders")
                    @else
                      @include("frontendViews.user.account.partials.single_order")
                    @endif
                  </div>
                  @endif
                  
                  @if(\Request::get('data') === "reservations")
                  <div class="tab-pane fade show active">
                     @include("frontendViews.user.account.partials.reservations")
                  </div>
                  @endif

                  @if(\Request::get('data') === "profile")
                  <div class="tab-pane fade show active">
                     @include("frontendViews.user.account.partials.profile")
                  </div>
                  @endif

                  @if(\Request::get('data') === "password")
                  <div class="tab-pane fade show active">
                     @include("frontendViews.user.account.partials.password")
                  </div>
                  @endif
                </div>
              </div>
            </div>

         </div>
      </section>

@endsection


@push("scripts")
<!-- datatable scripts -->
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="{{$publicAssetsPathStart}}plugins/dataTablesClientSide/config_js/datatable_config.js"></script>
@endpush