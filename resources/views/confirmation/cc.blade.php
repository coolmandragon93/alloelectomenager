@extends('layouts.application.template')

@section('title', 'Confirmation')

@section('content')

<?php 

$totalShipping = $order['total_shipping'] * 0.01;
$totalProduct = $order['total_products'] * 0.01;

?>

<div class="container info">
    <div class="row">
        <div class="col-sm-6 col-centered">
            <div class="confirmation-header">
            	<h1>Confirmation de la commande</h1>
            	<p><strong><?php echo $order['billing_first_name']; ?> <?php echo $order['billing_last_name']; ?></strong>, l'équipe d'AlloElectromenager vous remercie pour votre commande.</p>
                <p>Un e-mail de confirmation vient de vous être envoyé sur votre boite e-mail.</p>
            </div>
            <div class="confirmation-cart">
            	<h2>Récapitulatif de votre commande</h2>
            	<ul>
            		<li><strong>Numéro de commande :</strong> <?php echo $order['id']; ?></li>
            		@foreach(Cart::content() as $row)
                        <li class="item"><em style="background:url({{ $row->image }}) no-repeat center center/contain;"></em>{{ $row->name }}</a><br /><small>Ref : {{ $row->ref }}</small><br /><span>{{ my_format($row->total) }}€</span></li>
                    @endforeach
                    <li><strong>Livraison :</strong> <span>{{my_format($totalShipping)}}€</span></li>
                    <li><strong>Montant de la commande :</strong> <span>{{my_format($totalProduct + $totalShipping)}}€</span></li>
            	</ul>
            </div>
            <div class="confirmation-footer">
            	<p>Merci, nous traitons votre commande. Les détails de la commande sont ci-dessous.
                </p>
            </div>
            <div class="confirmation-button">
            	<button onclick="window.print();">IMPRIMER</button>
            </div>
        </div>
    </div>
</div>
@endsection