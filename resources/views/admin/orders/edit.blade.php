@extends('layouts.admin')

@section('title', 'Modifier')

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

    $next_day_num1 = $highestDate + 2;
    $next_day_num2 = $highestDate + 4;

    $tmp_deliver_date1 = strftime('%w', strtotime("+" . $next_day_num1 . " day"));
    $tmp_deliver_date2 = strftime('%w', strtotime("+" . $next_day_num2 . " day"));

    $tmp_date_off_num1 = $next_day_num1;
    $tmp_date_off_num2 = $next_day_num2;

    $tmp_date_of_week1 = strftime('%w', strtotime("+" . $tmp_date_off_num1 . " day"));
    $tmp_date_of_week2 = strftime('%w', strtotime("+" . $tmp_date_off_num2 . " day"));

    while ($tmp_date_of_week1 == 0 || $tmp_date_of_week1 == 6){
        $tmp_date_off_num1++;
        $tmp_date_of_week1 = strftime('%w', strtotime("+" . $tmp_date_off_num1 . " day"));
    }

    while ($tmp_date_of_week2 == 0 || $tmp_date_of_week2 == 6){
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


    <div class="row">
        
         <div class="col-lg-6">                <!-- Log Messages -->
            <div class="block status-select" >
                <div class="block-header bg-gray-lighter">
                    <h3 class="block-title">Changer l'adresse de facturation</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        
                        <form action="" method="post">
                            
                            <input type="hidden" name="_method" value="PUT">

                            {{ csrf_field() }}

                            <input class="form-control" name="shipping_first_name" type="text" value="{{ old('shipping_first_name', $order->shipping_first_name) }}" style="margin-top: 10px;" />

                            <input class="form-control" name="shipping_last_name" type="text" value="{{ old('shipping_last_name', $order->shipping_last_name) }}" style="margin-top: 10px;" />

                            <input class="form-control" name="email" type="text" value="{{ old('email', $order->email) }}" style="margin-top: 10px;" />

                            <input class="form-control" name="billing_phone" type="text" value="{{ old('billing_phone', $order->billing_phone) }}" style="margin-top: 10px;" />

                            <input class="form-control" name="billing_address" type="text" value="{{ old('billing_address', $order->billing_address) }}" style="margin-top: 10px;" />

                            <input class="form-control" name="billing_city" type="text" value="{{ old('billing_city', $order->billing_city) }}" style="margin-top: 10px;" />
                            <input class="form-control" name="billing_country" type="text" value="{{ old('billing_country', $order->billing_country) }}" style="margin-top: 10px;" />
                            <input class="form-control" name="billing_zip" type="text" value="{{ old('billing_zip', $order->billing_zip) }}" style="margin-top: 10px;" />

                            <button class="label label-primary" style="margin:10px 0 10px 0;padding:10px;text-transform:uppercase;outline:none;border:0;">Modifier</button>
                        </form>
                    </div>
                </div>
            </div>
         </div>
         <div class="col-lg-6">                <!-- Log Messages -->
            <div class="block status-select" >
                <div class="block-header bg-gray-lighter">
                    <h3 class="block-title">Changer l'adresse de livraison</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        
                        <form action="" method="post">
                            
                            <input type="hidden" name="_method" value="PUT">

                            {{ csrf_field() }}

                            
                            <input class="form-control" name="shipping_first_name" type="text" value="{{ old('shipping_first_name', $order->shipping_first_name) }}" style="margin-top: 10px;" />

                            <input class="form-control" name="shipping_last_name" type="text" value="{{ old('shipping_last_name', $order->shipping_last_name) }}" style="margin-top: 10px;" />

                            <input class="form-control" name="email" type="text" value="{{ old('email', $order->email) }}" style="margin-top: 10px;" />

                            <input class="form-control" name="billing_phone" type="text" value="{{ old('billing_phone', $order->billing_phone) }}" style="margin-top: 10px;" />

                            <input class="form-control" name="shipping_address" type="text" value="{{ old('shipping_address', $order->shipping_address) }}" style="margin-top: 10px;" />

                            <input class="form-control" name="shipping_city" type="text" value="{{ old('shipping_city', $order->shipping_city) }}" style="margin-top: 10px;" />
                            <input class="form-control" name="shipping_country" type="text" value="{{ old('shipping_country', $order->shipping_country) }}" style="margin-top: 10px;" />
                            <input class="form-control" name="shipping_zip" type="text" value="{{ old('shipping_zip', $order->shipping_zip) }}" style="margin-top: 10px;" />

                            <button class="label label-primary" style="margin:10px 0 10px 0;padding:10px;text-transform:uppercase;outline:none;border:0;">Modifier</button>
                        </form>
                    </div>
                </div>
            </div>
         </div>
         </div>
              
            </div>
            <!-- END Customer -->

           
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