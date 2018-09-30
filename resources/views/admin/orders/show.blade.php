@extends('layouts.admin')

@section('title', 'Commande')

@section('content')

    <?php
    $paymentType = $order->payment_type;
    $status = ['Carte de crédit','PayPal','Virement bancaire','Chéque'];

    Date::setLocale('fr');
    ?>
 <?php

    $cart = Cart::content();
    $datesArray = [];
    $highestDate = 0;

    if( count($cart) > 0 ) {
        foreach($cart as $key => $value) {
            array_push($datesArray,$cart[$key] -> deliveryInt);
        }

        $highestDate = max($datesArray);
    }


    Date::setLocale('fr');

    $next_day_num1 = $highestDate + 3;
    $next_day_num2 = $highestDate + 5;

    $tmp_deliver_date1 = strftime('%w', strtotime("+" . $next_day_num1 . " day"));
    $tmp_deliver_date2 = strftime('%w', strtotime("+" . $next_day_num2 . " day"));

    $tmp_date_off_num1 = $next_day_num1;
    $tmp_date_off_num2 = $next_day_num2;

    $tmp_date_of_week1 = strftime('%w', strtotime("+" . $tmp_date_off_num1 . " day"));
    $tmp_date_of_week2 = strftime('%w', strtotime("+" . $tmp_date_off_num2 . " day"));

    while ($tmp_date_of_week1 == 0 || $tmp_date_of_week1 == 5){
        $tmp_date_off_num1++;
        $tmp_date_of_week1 = strftime('%w', strtotime("+" . $tmp_date_off_num1 . " day"));
    }

    while ($tmp_date_of_week2 == 0 || $tmp_date_of_week2 == 7){
        $tmp_date_off_num2++;
        $tmp_date_of_week2 = strftime('%w', strtotime("+" . $tmp_date_off_num2 . " day"));
    }

    $deliver_date1 = new Date("+" . $tmp_date_off_num1 . " day");
    $deliver_date1 = $deliver_date1->format('l j F');

    $deliver_date2 = new Date("+" . $tmp_date_off_num2 . " day");
    $deliver_date2 = $deliver_date2->format('l j F');


    ?>
    <!-- Main Container -->
    <main id="main-container">
        <!-- Page Header -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        Order #{{ $order->id }} <small>{{$order->created_at}}</small>
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                        <li><a class="link-effect" href="{{ route('admin.orders.index') }}">Orders</a></li>
                        <li>#{{ $order->id }}</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- END Page Header -->

    @include("includes.flash")

    <!-- Page Content -->
        <div class="content content-boxed">

            <!-- Log Messages -->
            <div class="block">
                <div class="block-header bg-gray-lighter">
                    <div class="block-options-simple btn-group btn-group-xs">
                        <a href="#" class="btn btn-default status-toggle" style="float:right"><i class="si si-bar-chart"></i> Changer état</a>
                        <a href="{{ route('admin.orders.order', $order->id) }}" class="btn btn-default status-toggle" style="margin-right: 10px; float:right"><i class="si si-doc"></i> Facture</a>
                    </div>
                    <h3 class="block-title">Status</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped table-vcenter">
                            <tbody>
                            <tr>
                                <td style="width: 200px;" nowrap="nowrap">
                                                <span class="font-w600">
                                                    <?php $tmp_date = new Date(strtotime($order->created_at->format('Y-m-d H:i:s'))); ?>
                                                    {{ ucwords($tmp_date->format('l j F, H:i:s')) }}
                                                </span>
                                </td>
                                <td>
                                    <span class="label label-{{get_color_status($order->state())}}">{{ $order->state() }}</span>
                                </td>
                                <td >Type de paiement : <strong><?php echo $status[$paymentType - 1]; ?></strong></td>
                                @if($order->tracking)
                                    <td ><strong>Tracking:</strong> {{ $order->tracking }}</td>
                                @endif
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END Log Messages -->
        <?php if($paymentType == 1 || $paymentType == 2){ ?>
        <!-- Log Messages -->
            <div class="block">
                <div class="block-header bg-gray-lighter">
                    <h3 class="block-title">Invoice</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped table-vcenter">
                            <tbody>
                            <tr>
                                <td style="width:50%;" nowrap="nowrap">
                                    Last Sent: <b>
                                        <?php $tmp_date = new Date(strtotime($order->invoice_at)); echo ucwords($tmp_date->format('l j F, H:i:s'));?></b>

                                </td>
                                <td style="width:50%;" nowrap="nowrap"><a href="{{ route('admin.orders.send', $order->id) }}" class="btn btn-default status-toggle" style="float:right"><i class="si si-doc"></i> Send Invoice</a></td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END Log Messages -->
        <?php } ?>
        <!-- Log Messages -->
            <div class="block status-select" style="display:none;">
                <div class="block-header bg-gray-lighter">
                    <h3 class="block-title">Changer l'état de la commande</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <span>État de la commande :</span>
                        <form id="statusForm" action="" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT">
                            <select class="form-control" name="status">
                                @foreach(\App\Order::$states as $key => $value)
                                    <option value="{{ $key }}" <?php if($order->state() == $value){echo "selected";}; ?>>{{ $value }}</option>
                                @endforeach
                            </select>
                            <input class="form-control" name="data" type="text" value="" placeholder="Info" style="margin-top: 10px;" />
                            <button class="label label-primary" style="margin:10px 0 10px 0;padding:10px;text-transform:uppercase;outline:none;border:0;">Confirmer</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END Log Messages -->

            <!-- Products -->
            <div class="block">
                <div class="block-header bg-gray-lighter">
                    <h3 class="block-title">Produits</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped table-vcenter">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 100px;">ID</th>
                                <th></th>
                                <td class="text-center"></td>
                                <th class="text-center">Quantité</th>
                                <th class="text-right" style="width: 10%;">Prix a l'unité</th>
                                <th class="text-right" style="width: 10%;">Prix total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->lines as $line)
                                <tr>
                                    <td class="text-center"><strong>{{ $line->product_id }}</strong></td>
                                    <td>{{ $line->name }}</td>
                                    <td class="text-center"></td>
                                    <td class="text-center"><strong>{{ $line->quantity }}</strong></td>
                                    <td class="text-right">{{ $line->price }} €</td>
                                    <td class="text-right">{{ my_format(httottc($line->price) * $line->quantity) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" class="text-right"><strong>Prix total des produits :</strong></td>
                                <td class="text-right">{{ my_format(($order -> total_products)) }}€</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><strong>Livraisons :</strong></td>
                                <td class="text-right">

                                @if (($order -> billing_country) === "France")
                                      {{ my_format(($order -> total_shipping)) }}€
                                    
                                @else
                                         {{ my_format(($order -> total_shipping + 2)) }}€
                                @endif
 

                                </td>
                            </tr>
                            </tr>
                                <td colspan="5" class="text-right"><strong>Date livraison prévu :</strong></td>
                                <td class="text-right">

                                   
                                        <?php if (my_format(($order->total_shipping)) == 6.90) {
                                            echo $deliver_date2; 
                                        }
                                        else 

                                            echo $deliver_date1;
                                        ?>

                                        
                                    
                                
                                        
                                   


                                </td>
                            <tr>
                            <tr class="success">
                                <td colspan="5" class="text-right text-uppercase"><strong>Total :</strong></td>
                                <td class="text-right"><strong>
                                    
                                @if (($order -> billing_country) === "France")
                                    {{ my_format(( $order -> total_products + $order -> total_shipping )) }}€
                                @else

                                    {{ my_format(( $order -> total_products + $order -> total_shipping + 2 )) }}€

                                @endif</strong></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END Products -->



            <!-- Customer -->
            <div class="row">
                <div class="col-lg-6">
                    <!-- Billing Address -->
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title">Adresse de facturation</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="h4 push-5">{{ $order -> billing_first_name }} {{ $order -> billing_last_name }}</div>
                            <address>
                                {{ $order -> billing_address }}<br>
                                {{ $order -> billing_city }}<br>
                                {{ $order -> billing_country }}, {{ $order -> billing_zip }}<br><br>
                                <i class="fa fa-phone"></i> {{ $order -> billing_phone }}<br>
                                <i class="fa fa-envelope-o"></i> <a href="mailto:{{ $order -> email }};">{{ $order -> email }}</a>
                            </address>
                        </div>
                    </div>
                    <!-- END Billing Address -->
                </div>
                <div class="col-lg-6">
                    <!-- Shipping Address -->
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title">Adresse de livraison</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="h4 push-5">{{ $order -> shipping_first_name }} {{ $order -> shipping_last_name }}</div>
                            <address>
                                {{ $order -> shipping_address }}<br>
                                {{ $order -> shipping_city }}<br>
                                {{ $order -> shipping_country }}, {{ $order -> shipping_zip }}<br><br>
                                <i class="fa fa-phone"></i> {{ $order -> shipping_phone }}<br>
                                <i class="fa fa-envelope-o"></i> <a href="mailto:{{ $order -> email }};">{{ $order -> email }}</a>
                            </address>
                        </div>
                    </div>
                    <!-- END Shipping Address -->
                </div>
            </div>
            <!-- END Customer -->

            <div class="row">
                <div class="col-md-12">
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title">Order History</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <table class="table table-striped table-hovered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->history as $history)
                                    <tr>
                                        <td>{{ $history->created_at }}</td>
                                        <td>{{ $history->state }}</td>
                                        <td><?php print_r($history->data); ?></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->

    <script type="text/javascript">

        var statusBtn = document.querySelector('a.status-toggle');

        if(statusBtn){
            var statusSelect = document.querySelector('select[name="status"]');

            if(statusSelect){
                statusSelect.addEventListener('change',function(){

                    var dataField = this.parentNode.querySelector('input[name=data]');

                    if(this.options[this.selectedIndex].value == "done") {
                        dataField.placeholder = "Tracking Number";
                        dataField.required = true;

                    } else {
                        dataField.placeholder = "Info";
                        dataField.required = false;
                    }
                });
            }

            statusBtn.addEventListener('click',function(e){
                e.preventDefault();
                this.style.display = 'none';
                console.log("test");
                this.ownerDocument.querySelector('.status-select').style.display = 'block';
            });
        }

    </script>

@endsection
