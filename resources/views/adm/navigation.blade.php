<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
          <a href="{{route('logout')}}" class="nav-link" onclick="event.preventDefault();this.closest('form').submit();">Logout</a>
      </form>
    </ul>


  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
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
      </nav>
    </div>
  </aside>
