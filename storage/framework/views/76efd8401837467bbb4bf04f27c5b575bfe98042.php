<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <?php /* Encrypted CSRF token for Laravel, in order for Ajax requests to work */ ?>
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="/css/common.css" rel="stylesheet" type="text/css" />
  <link href="/css/app.css" rel="stylesheet" type="text/css" />

  <!-- Builded begining script -->
  <script src="/js/vendor.js"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body id="App">

  <?php echo $__env->make('blocks.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <router-view
    transition="fade"
    transition-mode="out-in"
    v-cloak
    keep-alive
  ></router-view>

  <?php echo $__env->make('blocks.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <?php /* Data from Backend */ ?>
  <script type="text/javascript">
    window['slides'] = <?php echo $slides; ?>;
    window['seances'] = <?php echo $seances; ?>;
    window['programs'] = <?php echo $programs; ?>;
    window['events'] = <?php echo $events; ?>;
    window['places'] = <?php echo $places; ?>;
    window['categories'] = <?php echo $categories; ?>;
  </script>

  <script src="/js/main.js"></script>

</body>

</html>
