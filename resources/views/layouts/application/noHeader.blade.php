<!DOCTYPE HTML>
<html lang="fr">

<head>
  @if(isset($order) || isset($postData))
  <?php
  error_log("-- Tag test".PHP_EOL, 3, "/var/tmp/test-gtag.log");
  error_log(Route::currentRouteName().PHP_EOL, 3, "/var/tmp/test-gtag.log");
  error_log(Route::currentRouteName().PHP_EOL, 3, "/var/tmp/possibleroutes.log");
  //error_log(print_r(Route::current(), true).PHP_EOL, 3, "/var/tmp/test-gtag.log");

  if(isset($order)) {
    error_log("order:".PHP_EOL.print_r($order, true).PHP_EOL, 3, "/var/tmp/test-gtag.log");
    if(is_object($order)) {
      $orderId = $order->id;
      $total_tax = \App\PriceRule::removeVta(my_format($order->total_products)+my_format($order->total_shipping));
      $total_products = my_format($order->total_products);
      $total_shipping = my_format($order->total_shipping);
    } else {
      $orderId = $order['id'];
      $total_tax = \App\PriceRule::removeVta(my_format($order['total_products']*0.01)+my_format($order['total_shipping']*0.01));
      $total_products = my_format($order['total_products']*0.01);
      $total_shipping = my_format($order['total_shipping']*0.01);
    }
  } else {
    error_log("postData:".PHP_EOL.print_r($postData, true).PHP_EOL, 3, "/var/tmp/test-gtag.log");
      $shipping = App\Shipping::shipping()['total'];

      if(strtolower($postData['billing_country']) != 'france'){
          $shipping = (float) $shipping + 2;
      }

      $orderId = $postData['orderId'];
      $total_tax = my_format(Cart::total() - \App\PriceRule::removeVta(Cart::total()));
      $total_products = my_format(Cart::total());
      $total_shipping = $shipping;
  }

  error_log(PHP_EOL.PHP_EOL, 3, "/var/tmp/test-gtag.log");

  ?>
  <script>
  window.dataLayer = window.dataLayer || []
  dataLayer.push({
     'transactionId': '{{ $orderId }}',
     'transactionTotal': {{ $total_products }},
     'transactionTax': {{ $total_tax }},
     'transactionShipping': {{ $total_shipping }},
     'event': "transactionCompleted"
  });
  </script>
  @endif

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-MVZTBXD');</script>
  <!-- End Google Tag Manager -->

	<title>@yield('title') - AlloElectromenager</title>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">
	<meta name="keywords" content="@yield('keywords')" />
	<meta name="description" content="@yield('description')">
	<meta name="author" content="alloelectromenager.com">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='http://fonts.googleapis.com/css?family=Roboto:500,300,700,400italic,400' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{!! asset('assets/front/css/bootstrap.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/front/css/font-awesome.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/front/css/styles.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/front/css/custom.css') !!}">
	<script src="{!! asset('assets/front/js/jquery.js') !!}"></script>

</head>

<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MVZTBXD"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->


	<div class="global-wrapper clearfix" id="global-wrapper">
		
		@yield('content')
		
        @include('layouts.application.footer')
				
	</div>		

</body>

</html>
