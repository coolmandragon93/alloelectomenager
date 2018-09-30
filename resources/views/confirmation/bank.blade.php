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
            	<p>
                    <br>Effectuez votre paiement directement depuis votre compte bancaire.
                    <br>Veuillez utiliser votre n° de commande <b><?php echo $postData['orderId']; ?></b> comme référence de paiement.</p>
                    <br><span style="font-weight:bold;font-size:16px;">Nos coordonnées</span><br /><br />
                    <ul>
                        <li>Titulaire du compte: SILVER STONE MONACO SARL</li><li>Numéro du compte: 00010215320</li><li>Code Banque/Guichet: 30004 09170</li><li>Nom de la banque: BNP PARIBAS MONTE-CARLO</li><li>IBAN: MC58 3000 4091 7000 0102 1532 076</li><li>BIC: BNPAMCM1</li></ul>

                <p>Votre commande ne sera livrée qu’à réception des fonds sur notre compte.</p>
            </div>
            <div class="confirmation-button">
            	<button onclick="window.print();">IMPRIMER</button>
            </div>
        </div>
    </div>
</div>
 
@endsection
