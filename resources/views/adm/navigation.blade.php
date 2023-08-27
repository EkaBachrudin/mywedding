<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>


  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="position-fixed main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link text-center"> <span class="brand-text font-weight-light">ADMINISTRATOR</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- SidebarSearch Form -->
      <div class="form-inline mt-4">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="/administrator" class="nav-link"><i class="nav-icon fas fa-users me-5"></i><p>All Guest</p></a>
          </li>
        </ul>
        <form method="POST" action="{{ route('logout') }}" style="position: absolute;bottom: 20px">
            @csrf
            <a style="width: fit-content" href="{{route('logout')}}" class="logout-btn btn btn-sm btn-danger" onclick="event.preventDefault();check = confirm('Do you really want to logout?');if(check){this.closest('form').submit();}">Logout</a>
        </form>
      </nav>
    </div>
  </aside>
