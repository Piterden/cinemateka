<!DOCTYPE html>
<html>

<head>
  <title>Кино в городе</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  {{-- Encrypted CSRF token for Laravel, in order for Ajax requests to work --}}
  <!-- <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css" /> -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="/css/common.css" rel="stylesheet" type="text/css" />
  <link href="/css/app.css" rel="stylesheet" type="text/css" />

  {{-- Data from Backend --}}
  <script type="text/javascript">
    window['seances'] = {!! $seances !!};
    window['programs'] = {!! $programs !!};
    window['events'] = {!! $events !!};
    window['places'] = {!! $places !!};
    window['categories'] = {!! $categories !!};
  </script>

  <!-- Builded begining script -->
  <script src="/js/vendor.js"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
</head>

<body id="App">

  @include('blocks.header')

  <router-view
    transition="fade"
    transition-mode="out-in"
    v-cloak
  >
      @yield('top-block')
  </router-view>

  @include('blocks.footer')

  <script src="/js/main.js"></script>

</body>

</html>
