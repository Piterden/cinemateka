@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="{{ Auth::user()->image }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">ADMINISTRATION</li>
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
          <!-- Pages -->
          <li><a href="{{ url('admin/page') }}"><i class="fa fa-file-o"></i> <span>Pages</span></a></li>
          <!-- Menu -->
          <li><a href="{{ url('admin/menu-item') }}"><i class="fa fa-list"></i> <span>Menu</span></a></li>

          <li><a href="{{ url('admin/event') }}"><i class="fa fa-film"></i> <span>Events</span></a></li>
          <li><a href="{{ url('admin/program') }}"><i class="fa fa-calendar"></i> <span>Programs</span></a></li>
          <li><a href="{{ url('admin/seance') }}"><i class="fa fa-clock-o"></i> <span>Seances</span></a></li>
          <!-- File Manager -->
          <li>
            <a href="{{ url('admin/elfinder') }}"><i class="fa fa-files-o"></i> <span>File manager</span></a>
          </li>
          <!-- Settings -->
          <li>
            <a href="{{ url('admin/setting') }}"><i class="fa fa-cog"></i> <span>Settings</span></a>
          </li>
          <!-- Backup -->
          <li>
            <a href="{{ url('admin/backup') }}"><i class="fa fa-hdd-o"></i> <span>Backups</span></a>
          </li>
          <!-- Language -->
          <li class="treeview">
            <a href="#"><i class="fa fa-globe"></i> <span>Translations</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url('admin/language') }}"><i class="fa fa-flag-checkered"></i> Languages</a></li>
              <li><a href="{{ url('admin/language/texts') }}"><i class="fa fa-language"></i> Site texts</a></li>
            </ul>
          </li>

          <!-- ======================================= -->
          <li class="header">USER</li>
          <!-- Users, Roles Permissions -->
          <li class="treeview">
            <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url('admin/user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
              <li><a href="{{ url('admin/role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
              <li><a href="{{ url('admin/permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
            </ul>
          </li>
          <li><a href="{{ url('admin/logout') }}"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
