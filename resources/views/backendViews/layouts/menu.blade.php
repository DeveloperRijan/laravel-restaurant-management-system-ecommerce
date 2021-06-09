
  <li class="nav-item">
     <a class="nav-link " href="{{route('admin.dashboard')}}">
        <i class="nav-icon fa fa-dashboard"></i>            
        <p>Dashboard</p>
     </a>
  </li>

  <li class="nav-header">App Management</li>
  <li class="nav-item has-treeview ">
     <a href="#" class="nav-link ">
        <i class="nav-icon fa fa-database"></i>            
        <p>App <i class="right fa fa-angle-left"></i>
        </p>
     </a>
     <ul class="nav nav-treeview">
        <li class="nav-item">
           <a class="nav-link " href="{{route('admin.frontend-ui.index')}}">
              <i class="nav-icon fa fa-reorder"></i>
              <p>Frontend & Contacts</p>
           </a>
        </li>
        <li class="nav-item">
           <a class="nav-link " href="{{route('admin.home-content.index')}}">
              <i class="nav-icon fa fa-reorder"></i>
              <p>Home Content</p>
           </a>
        </li>
        <li class="nav-item">
           <a class="nav-link " href="{{route('admin.sliders.index')}}">
              <i class="nav-icon fa fa-reorder"></i>
              <p>Sliders</p>
           </a>
        </li>
     </ul>
  </li>
  <li class="nav-item">
     <a class="nav-link " href="{{route('admin.categories.index')}}">
        <i class="nav-icon fa fa-folder"></i>
        <p>Categories/Menu</p>
     </a>
  </li>
  <li class="nav-item has-treeview ">
     <a href="#" class="nav-link ">
        <i class="nav-icon fa fa-archive"></i>            
        <p>Products/Items <i class="right fa fa-angle-left"></i>
        </p>
     </a>
     <ul class="nav nav-treeview">
        <li class="nav-item">
           <a class="nav-link " href="{{route('admin.products.index')}}">
              <i class="nav-icon fa fa-archive"></i>                        
              <p>Products</p>
           </a>
        </li>
     </ul>
  </li>
  <li class="nav-item has-treeview ">
     <a href="#" class="nav-link ">
        <i class="nav-icon fa fa-shopping-bag"></i>            
        <p>Orders <i class="right fa fa-angle-left"></i>
        </p>
     </a>
     <ul class="nav nav-treeview">
        <li class="nav-item">
           <a class="nav-link " href="{{route('admin.orders.index')}}?type=New">
              <i class="nav-icon fa fa-shopping-bag"></i>
              <p>Orders</p>
           </a>
        </li>
     </ul>
  </li>
  <li class="nav-item">
     <a class="nav-link " href="{{route('admin.coupons.index')}}">
        <i class="nav-icon fa fa-ticket"></i>
        <p>Coupons</p>
     </a>
  </li>

  <li class="nav-header">Users Management</li>
  <li class="nav-item">
     <a class="nav-link " href="{{route('admin.users.index')}}?type=customers">
        <i class="nav-icon fa fa-users"></i>
        <p>Customers</p>
     </a>
  </li>
  <li class="nav-item has-treeview ">
     <a href="#" class="nav-link ">
        <i class="nav-icon fa fa-users"></i>            
        <p>Staffs <i class="right fa fa-angle-left"></i>
        </p>
     </a>
     <ul class="nav nav-treeview">
        <li class="nav-item">
           <a class="nav-link " href="{{route('admin.users.index')}}?type=staffs">
              <i class="nav-icon fa fa-reorder"></i>
              <p>Staffs</p>
           </a>
        </li>
        <li class="nav-item">
           <a class="nav-link " href="{{route('admin.add.batch.coupon.get')}}">
              <i class="nav-icon fa fa-reorder"></i>
              <p>Add Batch Coupon</p>
           </a>
        </li>
        {{--
        <li class="nav-item">
           <a class="nav-link " href="{{route('admin.staffs.create')}}">
              <i class="nav-icon fa fa-reorder"></i>
              <p>Invite Staff</p>
           </a>
        </li>
        --}}
     </ul>
  </li>
  <li class="nav-item has-treeview ">
     <a href="#" class="nav-link ">
        <i class="nav-icon fa fa-cutlery"></i>            
        <p>Kitchen <i class="right fa fa-angle-left"></i>
        </p>
     </a>
     <ul class="nav nav-treeview">
        <li class="nav-item">
           <a class="nav-link " href="{{route('admin.users.index')}}?type=kitchen_staffs">
              <i class="nav-icon fa fa-reorder"></i>
              <p>Staffs</p>
           </a>
        </li>
        <li class="nav-item">
           <a class="nav-link " href="{{route('admin.add.kitchen.staff.form')}}">
              <i class="nav-icon fa fa-reorder"></i>
              <p>Add Staff</p>
           </a>
        </li>
     </ul>
  </li>


  <li class="nav-header">Settings</li>
  <li class="nav-item has-treeview ">
     <a href="#" class="nav-link ">
        <i class="nav-icon fa fa-credit-card"></i>            
        <p>Payments<i class="right fa fa-angle-left"></i>
        </p>
     </a>
     <ul class="nav nav-treeview">
        <li class="nav-item">
           <a class="nav-link " href="{{route('admin.payment-gateway.index')}}">
              <i class="nav-icon fa fa-money"></i>
              <p>Payment Gateways</p>
           </a>
        </li>
     </ul>
  </li>

  <li class="nav-item has-treeview ">
     <a href="#" class="nav-link ">
        <i class="nav-icon fa fa-truck"></i>            
        <p>Delivery<i class="right fa fa-angle-left"></i>
        </p>
     </a>
     <ul class="nav nav-treeview">
        <li class="nav-item">
           <a class="nav-link " href="{{route('admin.delivery-charge.index')}}">
              <i class="nav-icon fa fa-truck"></i>
              <p>Delivery Charge</p>
           </a>
        </li>
     </ul>
  </li>

  <li class="nav-item has-treeview ">
     <a href="#" class="nav-link ">
        <i class="nav-icon fa fa-map-pin"></i>            
        <p>PostCode<i class="right fa fa-angle-left"></i>
        </p>
     </a>
     <ul class="nav nav-treeview">
        <li class="nav-item">
           <a class="nav-link " href="{{route('admin.postcodes.index')}}">
              <i class="nav-icon fa fa-map-pin"></i>
              <p>Post Code Setup</p>
           </a>
        </li>
     </ul>
  </li>

  <li class="nav-item has-treeview ">
     <a href="#" class="nav-link ">
        <i class="nav-icon fa fa-minus"></i>            
        <p>Batch Coupon<i class="right fa fa-angle-left"></i>
        </p>
     </a>
     <ul class="nav nav-treeview">
        <li class="nav-item">
           <a class="nav-link " href="{{route('admin.batch.coupon.setting')}}">
              <i class="nav-icon fa fa-minus"></i>
              <p>Batch Coupon Setting</p>
           </a>
        </li>
     </ul>
  </li>
  <li class="nav-item has-treeview ">
     <a href="#" class="nav-link ">
        <i class="nav-icon fa fa-list"></i>            
        <p>Designations<i class="right fa fa-angle-left"></i>
        </p>
     </a>
     <ul class="nav nav-treeview">
        <li class="nav-item">
           <a class="nav-link " href="{{route('admin.designations.index')}}">
              <i class="nav-icon fa fa-list"></i>
              <p>Staff Designations</p>
           </a>
        </li>
     </ul>
  </li>
  <li class="nav-item has-treeview ">
     <a href="#" class="nav-link ">
        <i class="nav-icon fa fa-truck"></i>            
        <p>Delivery Type <i class="right fa fa-angle-left"></i>
        </p>
     </a>
     <ul class="nav nav-treeview">
        <li class="nav-item">
           <a class="nav-link " href="{{route('admin.staff.allowedForDelivery.order')}}">
              <i class="nav-icon fa fa-truck"></i>
              <p>Staff</p>
           </a>
        </li>
     </ul>
  </li>

  <li class="nav-item has-treeview ">
     <a href="#" class="nav-link ">
        <i class="nav-icon fa fa-bell"></i>            
        <p>Notifications <i class="right fa fa-angle-left"></i>
        </p>
     </a>
     <ul class="nav nav-treeview">
        <li class="nav-item">
           <a class="nav-link " href="{{route('admin.notification-settings.index')}}">
              <i class="nav-icon fa fa-bell"></i>
              <p>Settings</p>
           </a>
        </li>
     </ul>
  </li>
  <br><br>


  



