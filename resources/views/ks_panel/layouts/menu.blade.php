
  <li class="nav-item">
     <a class="nav-link " href="{{route('ks.dashboard')}}">
        <i class="nav-icon fa fa-dashboard"></i>            
        <p>Dashboard</p>
     </a>
  </li>

  <li class="nav-item has-treeview ">
     <a href="#" class="nav-link ">
        <i class="nav-icon fa fa-shopping-bag"></i>            
        <p>Orders <i class="right fa fa-angle-left"></i>
        </p>
     </a>
     <ul class="nav nav-treeview">
        <li class="nav-item">
           <a class="nav-link " href="{{route('ks.orders.index')}}?type=New">
              <i class="nav-icon fa fa-shopping-bag"></i>
              <p>Orders</p>
           </a>
        </li>
     </ul>
  </li>

  <li class="nav-item has-treeview ">
     <a href="#" class="nav-link ">
        <i class="nav-icon fa fa-archive"></i>            
        <p>Products/Items <i class="right fa fa-angle-left"></i>
        </p>
     </a>
     <ul class="nav nav-treeview">
        <li class="nav-item">
           <a class="nav-link " href="{{route('ks.products.index')}}">
              <i class="nav-icon fa fa-archive"></i>                        
              <p>Products</p>
           </a>
        </li>
     </ul>
  </li>

  <li class="nav-header">Users Management</li>
  <li class="nav-item">
     <a class="nav-link " href="{{route('ks.users.index')}}?type=customers">
        <i class="nav-icon fa fa-users"></i>
        <p>Customers</p>
     </a>
  </li>
  <li class="nav-item">
     <a class="nav-link " href="{{route('ks.users.index')}}?type=staffs">
        <i class="nav-icon fa fa-users"></i>
        <p>Staffs</p>
     </a>
  </li>


<br><br>


  



