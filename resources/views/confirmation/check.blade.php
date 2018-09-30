@extends('layouts.application.template')

@section('title', 'Confirmation')

@section('content')

<?php 

$shipping = App\Shipping::shipping()['total'];

if(strtolower($postData['billing_country']) != 'france'){
    $shipping = (float) $shipping + 2;  
}


?>

<div class="container info">
    <div class="row">
        <div class="col-sm-6 col-centered">
            <div class="confirmation-header">
            	<h1>Confirmation de la commande</h1>
            	<p><strong><?php echo $postData['billing_first_name']; ?> <?php echo $postData['billing_last_name']; ?></strong>, l'équipe d'AlloElectromenager vous remercie pour votre commande.</p>
                <p>Un e-mail de confirmation vient de vous être envoyé sur votre boite e-mail.</p>
            </div>
            <div class="confirmation-cart">
            	<h2>Récapitulatif de votre commande</h2>
            	<ul>
            		<li><strong>Numéro de commande :</strong> <?php echo $postData['orderId']; ?></li>
            		@foreach(Cart::content() as $row)
                        <li class="item"><em style="background:url({{ $row->image }}) no-repeat center center/contain;"></em>{{ $row->name }}</a><br /><small>Ref: {{ $row->ref }}</small><br /><span>{{ my_format($row->total) }}€</span></li>
                    @endforeach
                    <li><strong>Livraison :</strong> <span>{{my_format($shipping)}}€</span></li>
                    <li><strong>Montant de la commande :</strong> <span>{{my_format(Cart::total() + $shipping)}}€</span></li>
            	</ul>
            </div>
            <div class="confirmation-footer">
                <p>Veuillez noter le numéro de commande <b><?php echo $postData['orderId']; ?></b> au dos de votre chèque, établi a l’ordre de Silver Stone Monaco à l’adresse suivante :
                    <br>Silver Stone monaco
                    <br>« Service comptabilité »
                    <br>48 Boulevard du Jardin Exotique,
                    <br>98000, Monte Carlo.</p>
            	<p>Votre commande sera expédiée à la réception de votre chèque.</p>
            </div>
            <div class="confirmation-button">
            	<button onclick="window.print();">IMPRIMER</button>
            </div>
        </div>
    </div>
</div>

@endsection
