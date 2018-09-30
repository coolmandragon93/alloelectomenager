@extends('layouts.application.template')

@section('title', 'Confirmation')

@section('content')

    <?php

    $cart = json_decode($cart[0] -> items,true);
    $paymentType = $order -> payment_type;

    Date::setLocale('fr');

    ?>

    <div class="container info">
        <div class="row">
            <div class="col-sm-6 col-centered">
                <div class="confirmation-header">
                    <h1>Confirmation de la commande</h1>
                    <p><strong><?php echo $order -> billing_first_name; ?> <?php echo $order -> billing_last_name; ?></strong>, l'équipe d'AlloElectromenager vous remercie pour votre commande.</p>
                    <p>Un e-mail de confirmation vient de vous être envoyé sur votre boite e-mail.</p>
                </div>
                <div class="confirmation-cart">
                    <h2>Récapitulatif de votre commande</h2>
                    <ul>
                        <li><strong>Numéro de commande :</strong> <?php echo $order -> id; ?></li>
                        <?php

                        foreach($cart as $key => $value) {
                        foreach($value as $index => $data) { ?>

                        <li class="item"><em style="background:url('{{ $data['image'] }}') no-repeat center center/contain;"></em><?php echo $data['name']; ?></a><br /><small>Ref : <?php echo $data['ref']; ?></small><br /><span><?php echo my_format($data['price'] * $data['qty']); ?> €</span></li>

                        <?php    };
                        }; ?>

                        <li><strong>Livraison :</strong> <span>{{ my_format(($order -> total_shipping) * 0.01) }} €</span></li>
                        <li><strong>Montant de la commande :</strong> <span>{{ my_format(($order -> total_products + $order -> total_shipping) * 0.01) }} €</span></li>
                    </ul>
                </div>
                <div class="confirmation-button">
                    <button onclick="window.print();">IMPRIMER</button>
                </div>
            </div>
        </div>
    </div>

@endsection
