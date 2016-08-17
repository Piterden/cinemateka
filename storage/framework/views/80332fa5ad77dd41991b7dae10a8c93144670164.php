<?php if(Auth::check()): ?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo e(Auth::user()->image); ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo e(Auth::user()->name); ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <!-- ================================================ -->
      <!-- ==== Recommended place for admin menu items ==== -->
      <!-- ================================================ -->
      <li><a href="<?php echo e(url('admin')); ?>"><i class="fa fa-calendar"></i> <span>Календарь</span></a></li>
      <li class="header">КАТАЛОГ</li>
      <li><a href="<?php echo e(url('admin/event')); ?>"><i class="fa fa-film"></i> <span>События</span></a></li>
      <li><a href="<?php echo e(url('admin/program')); ?>"><i class="fa fa-list-ul"></i> <span>Программы</span></a></li>
      <li><a href="<?php echo e(url('admin/place')); ?>"><i class="fa fa-map-marker"></i> <span>Площадки</span></a></li>
      <li class="header">САЙТ</li>
      <!-- Menu -->
      <li><a href="<?php echo e(url('admin/slide')); ?>"><i class="fa fa-sliders"></i> <span>Слайдеры</span></a></li>
      <li><a href="<?php echo e(url('admin/menu-item')); ?>"><i class="fa fa-list"></i> <span>Меню</span></a></li>
      <!-- File Manager -->
      <li>
        <a href="<?php echo e(url('admin/elfinder')); ?>"><i class="fa fa-files-o"></i> <span>Файлы</span></a>
      </li>
      <!-- Backup -->
      <li>
        <a href="<?php echo e(url('admin/backup')); ?>"><i class="fa fa-hdd-o"></i> <span>Резервные копии</span></a>
      </li>
      <!-- ======================================= -->
      <?php /* <li class="header"></li>
      <!-- Users, Roles Permissions -->
      <li class="treeview">
        <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li><a href="<?php echo e(url('admin/user')); ?>"><i class="fa fa-user"></i> <span>Users</span></a></li>
          <li><a href="<?php echo e(url('admin/role')); ?>"><i class="fa fa-group"></i> <span>Roles</span></a></li>
          <li><a href="<?php echo e(url('admin/permission')); ?>"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
        </ul>
      </li>
      <li><a href="<?php echo e(url('admin/logout')); ?>"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li> */ ?>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
<?php endif; ?>
