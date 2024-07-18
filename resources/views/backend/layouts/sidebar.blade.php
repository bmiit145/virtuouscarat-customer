<style>
     .nav-item.active .nav-link {
    color: #fff;
    background-color: #233766;
}

.collapse-item.active {
  color: #007bff; /* Change the color to blue */
  font-weight: bold; /* Make the text bold */
}

.bg-gradient-info {
    background-color: #132644 !important;
    background-size: cover;
}
</style>
<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
    <img src="{{asset('images/virtuouscarat-logo.png')}}" atl="virtuouscarat-logo" style="width: 50%;background: white;">
  </a>


  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item {{ request()->routeIs('admin') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
      </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

 

  <!--Orders -->
  <li class="nav-item {{ request()->routeIs('order.index') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('order.index') }}">
        <i class="fas fa-cart-plus"></i>
        <span>Orders</span>
    </a>
</li>




  <!-- Divider -->
  {{-- <hr class="sidebar-divider d-none d-md-block">
   <!-- Heading -->
  <div class="sidebar-heading">
      General Settings
  </div>

</li>

<!-- General settings -->
<li class="nav-item {{ request()->is('admin/settings*') ? 'active_tab' : '' }}">
    <a class="nav-link" href="{{ route('settings') }}">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
    </a>
</li>
<br> --}}

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>