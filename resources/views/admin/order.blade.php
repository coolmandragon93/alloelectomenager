@extends('layouts.admin')

@section('title', 'Commande')

@section('content')

<?php 
$paymentType = $order->payment_type;
$status = ['Carte de crédit','PayPal','Virement bancaire','Chéque'];

Date::setLocale('fr');

?>

<!-- Main Container -->
<main id="main-container">
    <!-- Page Header -->
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-7">
                <h1 class="page-heading">
                    Admin <small></small>
                </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                    <li><a class="link-effect" href="{{ route('admin.index') }}">Accueil</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END Page Header -->

    <!-- Page Content -->
    <div class="content content-boxed">
        
        <!-- Header Tiles -->
                    <!--div class="row">
                        <div class="col-sm-6 col-md-3">
                            <div class="block text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <span class="item item-circle bg-success-light"><i class="fa fa-shopping-cart text-success"></i></span>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-success font-w600">ORD. {{ $order -> id }}</div>
                            </div>
                        </div>
                        <div class="col-sm-9 col-md-9">
                            <div class="block text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <span class="item item-circle"><i class="fa fa-question"></i></span>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter font-w600">Status: {{ $order -> status }}</div>
                            </div>
                        </div>
                        
                    </div-->
                    <!-- END Header Tiles -->

        <!-- Log Messages -->
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title">Status</h3><a href="#" class="label label-primary status-toggle" style="float:right">Changer état</a>
                        </div>
                        <div class="block-content">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-vcenter">
                                    <tbody>
                                        <tr>
                                            <td style="width: 80px;">
                                                <span class="label label-primary">Commande {{$order -> id}}</span>
                                            </td>
                                            <td style="width: 95px;">
                                                <span class="font-w600">{{ $order->created_at->format('j F, Y H:i:s') }}</span>
                                            </td>
                                            <td>
                                                Status : <strong>{{ $order->status }}</strong>
                                            </td>
                                            <td >Type de payement : <strong><?php echo $status[$paymentType - 1]; ?></strong></td>
                                            <td ><?php if($order -> tracking){ echo "N° suivi : <strong>".$order -> tracking."</strong>"; } ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END Log Messages -->   

        <!-- Log Messages -->
                    <div class="block status-select" style="display:none;">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title">Changer l'état de la commande</h3>
                        </div>
                        <div class="block-content">
                            <div class="table-responsive">
                                <span>État de la commande :</span>
                                <form id="statusForm" action="" method="post">
                                    <select class="form-control" name="status">
                                        <option value="Processing" <?php if($order -> status == 'Processing'){echo "selected";}; ?>>En cours</option>
                                        <option value="Hold" <?php if($order -> status == 'Hold'){echo "selected";}; ?>>En attente</option>
                                        <option value="Terminée" <?php if($order -> status == 'Terminée'){echo "selected";}; ?>>Terminée</option>
                                    </select>
                                    <input class="form-control" name="tracking" type="text" value="" placeholder="Tracking Number" style="margin:10px 0 0 0;" />
                                    <button class="label label-primary" style="margin:10px 0 10px 0;padding:10px;text-transform:uppercase;outline:none;border:0;">Confirmer</button>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                                            <td class="text-right">{{ my_format(($order -> total_shipping)) }}€</td>
                                        </tr>
                                        <tr class="success">
                                            <td colspan="5" class="text-right text-uppercase"><strong>Total :</strong></td>
                                            <td class="text-right"><strong>{{ my_format(($order -> total_products + $order -> total_shipping)) }}€</strong></td>
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


    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->

<script type="text/javascript">

var statusBtn = document.querySelector('a.status-toggle');

if(statusBtn){
    var statusSelect = document.querySelector('select[name="statusForm"]');

    if(statusSelect){
        statusSelect.addEventListener('change',function(){
            console.log(statusSelect);
            this.parentNode.querySelector('input').style.display = this.selectedIndex == 2 ? 'block' : 'none';
        });
    }

    var statusChange = document.querySelector('form#statusForm');

    if(statusChange){
        var statusButton = statusForm.querySelector('button');
        var tracking = statusForm.querySelector('input[name="tracking"]');

        statusButton.addEventListener('click',function(e){
            e.preventDefault();

            if(statusSelect.selectedIndex == 2 && tracking.value == ''){
                tracking.style.border = '1px solid #F00';
            }else{
                statusChange.submit();
            }
            
        });
    }

    statusBtn.addEventListener('click',function(e){
        e.preventDefault();
        this.style.display = 'none';
        this.ownerDocument.querySelector('.status-select').style.display = 'block';
    });
}

</script>

@endsection