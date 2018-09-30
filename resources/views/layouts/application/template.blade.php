<!DOCTYPE HTML>
<html lang="fr">
<head>
	@if(isset($order) || isset($postData))
	<?php
    error_log("-- Tag test".PHP_EOL, 3, "/var/tmp/test-gtag.log");
    error_log(Route::currentRouteName().PHP_EOL, 3, "/var/tmp/test-gtag.log");
    error_log(Route::currentRouteName().PHP_EOL, 3, "/var/tmp/possibleroutes.log");
    error_log(print_r($cart, true).PHP_EOL, 3, "/var/tmp/test-gtag.log");
    //error_log(print_r(Route::current(), true).PHP_EOL, 3, "/var/tmp/test-gtag.log");

    if (isset($order)) {
        error_log("order:".PHP_EOL.print_r($order, true).PHP_EOL, 3, "/var/tmp/test-gtag.log");
        if (is_object($order)) {
            $orderId = $order->id;
            $total_products = my_format($order->total_products*0.01);
            $total_shipping = my_format($order->total_shipping*0.01);
            $total = $total_products + $total_shipping;
            $total_tax = $total - \App\PriceRule::removeVta($total);
        } else {
            $orderId = $order['id'];
            $total_products = my_format($order['total_products']*0.01);
            $total_shipping = my_format($order['total_shipping']*0.01);
            $total = $total_products + $total_shipping;
            $total_tax = $total - \App\PriceRule::removeVta($total);
        }
    } else {
        error_log("postData:".PHP_EOL.print_r($postData, true).PHP_EOL, 3, "/var/tmp/test-gtag.log");
        $shipping = App\Shipping::shipping()['total'];

        if (strtolower($postData['billing_country']) != 'france') {
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
	   'transactionProducts': [
	   <?php foreach ($cartContent as $row) :?>
		   {
		       'sku': '{{ $row['ref'] }}',
		       'name': '{{ $row['name'] }}',
		       'price': {{ httottc($row['price']) }},
		       'quantity': {{ $row['qty'] }}
		   }
		<?php endforeach;?>
	   ],
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

	<?php if (isset($metaData['title'])) {
        ?>
	<title><?php echo $metaData['title'] ?></title>
	<?php
    } else {
        ?>
	<title>@yield('title')</title>
	<?php
    } ?>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">
	<?php if (isset($metaData['keywords'])) {
        ?>
	<meta name="keywords" content="<?php echo $metaData['keywords'] ?>" />
	<?php
    } else {
        ?>
	<meta name="keywords" content="@yield('keywords')" />
	<?php
    } ?>
	<?php if (isset($metaData['description'])) {
        ?>
	<meta name="description" content="<?php echo $metaData['description'] ?>" />
	<?php
    } else {
        ?>
	<meta name="description" content="@yield('description')" />
	<?php
    } ?>
	<?php if (isset($metaData['robots'])) {
        ?>
	<meta name="robots" content="<?php echo $metaData['robots'] ?>" />
	<?php
    } else {
        ?>
	<meta name="robots" content="@yield('robots')" />
	<?php
    } ?>
    <meta http-equiv="content-language" content="fr-FR" />
	<meta name="author" content="alloelectromenager.com">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="google-site-verification" content="Je-f2ZQYDM1z3-hIopqogYyYk4Z3tmvWN2pj0shrUr0" />
	<link href='//fonts.googleapis.com/css?family=Roboto:500,300,700,400italic,400' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{!! asset('assets/front/css/bootstrap.css') !!}">
		<link rel="stylesheet" href="{!! asset('assets/front/css/font-awesome.css') !!}">
		<link rel="stylesheet" href="{!! asset('assets/front/css/easy-autocomplete.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/front/css/styles.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/front/css/custom.css') !!}">
	<script src="{!! asset('assets/front/js/jquery.js') !!}"></script>



</head>

<body>
    <div id="loader-page"></div>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MVZTBXD"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<div class="global-wrapper clearfix" id="global-wrapper">
		
		@include('layouts.application.header')
		
		@yield('content')
		
        @include('layouts.application.footer')
				
	</div>

	<!-- Start of LiveChat (www.livechatinc.com) code -->
	<script type="text/javascript">
        window.__lc = window.__lc || {};
        window.__lc.license = 8739251;
        (function() {
            var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
            lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
        })();
	</script>
	<!-- End of LiveChat code -->
</body>

</html>
