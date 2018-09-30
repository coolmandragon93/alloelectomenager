<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>
        Imprimer la facture
    </title>
    <style media="screen,print">
        /* Simple CSS Reset and Print options
        ------------------------------------------*/

        html, body, div, span, h1, h2, h3, h4, h5, h6, p, a, table, ol, ul, dl, li, dt, dd {
            border: 0 none;
            font: inherit;
            margin: 0;
            padding: 0;
            vertical-align: baseline;
        }

        body {
            line-height: 1;
        }

        ol,
        ul {
            list-style: none;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        /* Main Body */
        body {
            background: #fff;
            color: #333;
            font-family: "HelveticaNeue", Helvetica, Arial, sans-serif;
            font-size: 0.875em;
            line-height: 125%;
            padding-top: 10px;
        }

        .page-break { display: block; page-break-before: always; }

        table{
            border-collapse: collapse;
        }

        th, td{
            border: 1px solid #bbb;
            padding: 4px;
        }
        @media print
        {
            .btn-print-invoice {
                display: none !important;
            }

            @page { margin: 0; }
        }
    </style>

</head>
<body>

<?php $i = 0;?>
@foreach($toprint as $t)
    @if($i > 0)
        <div class="page-break"></div>
    @endif

    <div style="padding: 0 30px; padding-top: 10px;">
        <div style="margin-top:20px;width:50%;float:left">
            <img src="{{ asset("assets/front/img/logos/alloelectro.png") }}" alt="AlloElectromenager" style="width: 250px;">
            <p style="width:100%;float:left">
                www.alloelectromenager.com        <br>
                48 boulevard du Jardin Exotique <br>
                98000 Monaco                   <br>
                Mail : alloelectromenager@gmail.com   <br>
                N° SIREN : 000098318             <br>
                TVA Intracommunautaire: FR86000098318<br>
            </p>
        </div>
        <div style="width:50%;float:right">
            <p style="margin:0;width:100%;float:left;text-align:right;">
                <strong>Client</strong><br><br>
                {{ $t->shipping_first_name }} {{ $t->shipping_last_name }} <br>
                {!! ( ! empty($t->shipping_company)) ? $t->shipping_company . '<br>' : null !!}
                {{ $t->shipping_address }}<br>
                {!! ( ! empty($t->shipping_address_2)) ? $t->shipping_address_2.'<br>' : null !!}
                {{ $t->shipping_postcode }} {{ $t->shipping_city }}<br>
                {{ $t->shipping_country }}
            </p>
        </div>
    </div>
    <div style="padding: 60px 30px; text-align: center; font-size: 28px;">
        <strong>FACTURE</strong>
    </div>
    <div style="padding: 0 30px;">
        <?php
        Date::setLocale('fr');

        $created_at = new Date($t->created_at);
        $created_at = $created_at->format('l j F');
        ?>
        <strong>Date de la facture :</strong> {{ $created_at  }} <br>
        <strong>Numéro de facture :</strong> {{ $t->id }}
    </div>
    <div style="padding: 30px; font-size: 12px;">
        <table style="margin: auto; width: 100%;">
            <thead>
            <tr>
                <th>Référence</th>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Montant HT</th>
                <th>TVA</th>
                <th>Montant TTC</th>
            </tr>
            </thead>
            <?php

            if(isset($t->lines)){
                $products = $t->lines;
            }
            ?>
            <tbody>
            @if(isset($products))
                @foreach($products as $p)

                    <tr>
                        <td>AT{{ $p->product_id }}</td>
                        <td>{{ $p->name }}</td>
                        <td style="text-align: center;">{{ $p->quantity }} </td>
                        <td style="text-align: center;"> {{ $p->price }}  €</td>
                        <td style="text-align: center;">{{ my_format($p->price * (100+$t->tax_rate) /100) }} €</td>
                        <td style="text-align: center;"> {{ my_format($p->price * $t->tax_rate/100) }} €</td>
                        <td style="text-align: right;"> {{ my_format($p->price * (100+$t->tax_rate) /100*$p->quantity) }} €</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>

        <table style="margin: auto; margin-top: 30px; width: 50%; float: right;">

            <thead>
            <tbody style="text-align: right;">
            <tr>
                <td>
                    <strong>
                        Total HT
                    </strong>
                </td>
                <td>{{ my_format($t->total_products) }} €</td>
            </tr>
            <tr>
                <td>
                    <strong>
                        TVA (20%)
                    </strong>
                </td>
                <td>{{ my_format($t->total_products-$t->total_products/($t->tax_rate+100)*100) }} €</td>
            </tr>
            <tr>
                <td>
                    <strong>
                        Livraisons
                    </strong>
                </td>
                <td>{{ my_format($t->total_shipping) }} €</td>
            </tr>
            @if(isset($t->total_discounts) && $t->total_discounts > 0)
                <tr>
                    <td><strong>Réduction</strong></td>
                    <td>- {{ my_format($t->total_discounts) }} €</td>
                </tr>
            @endif
            <tr>
                <td>
                    <strong>
                        Total TTC
                    </strong>
                </td>
                <td>{{ my_format(($t->total_products + $t->total_shipping)) }} €</td>
            </tr>
            </tbody>
        </table>

        <div style="clear: both;"></div>
    </div>

    <div style="padding: 30px; font-size: 10px; line-height: 1.2">
        Conditions de règlement :<br>
        - Par Chèque, par Virement ou par Paypal.<br>
        - Réserve de propriété : Nous nous réservons la propriété des marchandises jusqu’au complet paiement du prix par l’acheteur. Notre revendication porte aussi bien sur les marchandises que sur leur prix si elles ont déjà été revendues (Loi 80-335 du 12 mai 1980)<br><br>
        Pénalités en cas de retard : 1.5 fois taux d’intérêts légal en vigueur<br>
        48 Boulevard du Jardin Exotique ● 98000 Monaco ● alloelectromenager@gmail.com ● www.alloelectromenager.com<br>
    </div>

    <?php $i++; ?>

@endforeach
</body>
</html>
