<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php /* Encrypted CSRF token for Laravel, in order for Ajax requests to work */ ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

    <title>
      <?php echo e(isset($title) ? $title.' :: '.config('backpack.base.project_name').' Admin' : config('backpack.base.project_name').' Admin'); ?>

    </title>

    <?php echo $__env->yieldContent('before_styles'); ?>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/')); ?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/')); ?>/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/')); ?>/dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/')); ?>/plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/')); ?>/plugins/morris/morris.css">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/')); ?>/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <?php /* <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/')); ?>/plugins/datepicker/datepicker3.css"> */ ?>
    <?php /* <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/')); ?>/plugins/daterangepicker/daterangepicker-bs3.css"> */ ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/')); ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/')); ?>/plugins/pace/pace.min.css">
    <link rel="stylesheet" href="/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    <?php /* <link href="<?php echo e(asset('vendor/adminlte/')); ?>/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" /> */ ?>

    <?php /* <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/')); ?>/plugins/fullcalendar/fullcalendar.min.css"> */ ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/backpack/pnotify/pnotify.custom.min.css')); ?>">

    <!-- BackPack Base CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/backpack/backpack.base.css')); ?>">

    <?php echo $__env->yieldContent('after_styles'); ?>

    <!-- jQuery 2.2.0 -->
    <script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo e(asset('vendor/adminlte')); ?>/plugins/jQuery/jQuery-2.2.0.min.js"><\/script>')</script>
    <script type="text/javascript" src="/bower_components/moment/min/moment.min.js"></script>
    <script src="<?php echo e(asset('vendor/adminlte')); ?>/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo e(asset('vendor/adminlte')); ?>/plugins/pace/pace.min.js"></script>
    <script src="<?php echo e(asset('vendor/adminlte')); ?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo e(asset('vendor/adminlte')); ?>/plugins/fastclick/fastclick.js"></script>
    <script src="<?php echo e(asset('vendor/adminlte')); ?>/dist/js/app.min.js"></script>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition <?php echo e(config('backpack.base.skin')); ?> sidebar-mini" id="App">
    <!-- Site wrapper -->
    <div class="wrapper">

      <?php if(Auth::check()): ?>
        <header class="main-header">
          <!-- Logo -->
          <a href="<?php echo e(url('')); ?>" class="logo" target="_blank">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><?php echo config('backpack.base.logo_mini'); ?></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><?php echo config('backpack.base.logo_lg'); ?></span>
          </a>
          <!-- Header Navbar: style can be found in header.less -->
          <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>

            <?php echo $__env->make('backpack::inc.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          </nav>
          <?php /* <navbar></navbar> */ ?>
        </header>
      <?php endif; ?>

      <!-- =============================================== -->

      <?php echo $__env->make('backpack::inc.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
         <?php echo $__env->yieldContent('header'); ?>

        <!-- Main content -->
        <section class="content">

          <?php echo $__env->yieldContent('content'); ?>

        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <footer class="main-footer">
        <?php if(config('backpack.base.show_powered_by')): ?>
          <div class="pull-right hidden-xs">
            Powered by <a target="_blank" href="http://laravelbackpack.com">Laravel BackPack</a>
          </div>
        <?php endif; ?>
        Handcrafted by <a target="_blank" href="<?php echo e(config('backpack.base.developer_link')); ?>"><?php echo e(config('backpack.base.developer_name')); ?></a>.
      </footer>
    </div>
    <!-- ./wrapper -->

    <?php if(Auth::check()): ?>
      <?php /* Data from Backend */ ?>
      <script type="text/javascript">
        <?php /* Коллекции */ ?>
        window['seances'] = <?php echo $seances; ?>;
        window['programs'] = <?php echo $programs; ?>;
        window['events'] = <?php echo $events; ?>;
        window['places'] = <?php echo $places; ?>;
        window['categories'] = <?php echo $categories; ?>;
      </script>
    <?php endif; ?>

    <?php echo $__env->yieldContent('before_scripts'); ?>

    <?php /* <script src="<?php echo e(asset('vendor/adminlte')); ?>/plugins/datepicker/bootstrap-datepicker.js"></script> */ ?>
    <?php /* <script src="<?php echo e(asset('vendor/adminlte')); ?>/plugins/timepicker/bootstrap-timepicker.min.js"></script> */ ?>

    <!-- page script -->
    <script type="text/javascript">
        // To make Pace works on Ajax calls
        $(document).ajaxStart(function() { Pace.restart(); });

        // Ajax calls should always have the CSRF token attached to them, otherwise they won't work
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
    </script>

    <?php echo $__env->make('backpack::inc.alerts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php /* <script src="<?php echo e(asset('bower_components/vue/dist/vue.js')); ?>"></script> */ ?>
    <?php /* <script src="<?php echo e(asset('bower_components/vue-router/dist/vue-router.js')); ?>"></script> */ ?>
    <?php /* <?php echo $__env->make('vuetools::vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> */ ?>

    <?php echo $__env->yieldContent('after_scripts'); ?>

    <!-- JavaScripts -->
    <script src="/js/vendor.js"></script>
    <?php /* <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script> */ ?>
    <?php /* <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/locale/ru.js"></script> */ ?>
    <?php /* <script src="<?php echo e(asset('vendor/adminlte')); ?>/plugins/fullcalendar/fullcalendar.min.js"></script> */ ?>
    <?php /* <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.25/vue.js"></script> */ ?>
    <?php /* <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.9.1/vue-resource.js"></script> */ ?>
    <script src="<?php echo e(asset('js/admin.js')); ?>"></script>
</body>
</html>
