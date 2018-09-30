@extends('layouts.application.noHeader')
@section('title', 'Checkout')
@section('content')
    <?php
    $cart = Cart::content();
    $datesArray = [];
    foreach($cart as $key => $value) {
        array_push($datesArray,$cart[$key] -> deliveryInt);
    }
    $highestDate = max($datesArray);
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
    <div class="container checkout top-border">
        <div class="row">
            <div class="col-sm-4">
                <a href="{{ route('home') }}" class="btn btn-default" style="color: #eee;background-color: #888;border-color: #ccc; margin-bottom: 20px;"><i class="fa fa-caret-left"></i> Continuer les achats</a>
            </div>
            <div class="col-sm-4 text-center">
                <img src="/assets/front/img/logos/alloelectro.png" alt="AlloElectromenager" class="img-responsive" title="AlloElectromenager" style="margin-bottom: 20px;">
            </div>
            <div class="col-sm-4 checkout-labels">
                <ul>
                    <li>1 an de garantie</li>
                    <li>Livraison Express 24h/48h</li>
                    <li>Payement sécurisé</li>
                </ul>
            </div>
        </div>
    </div>
    <form action="{{ route('cart.payment') }}" method="post" name="checkout" novalidate>
        {{ csrf_field() }}
        <div class="container checkout">
            <div class="row">
                <div class="col-sm-12">
                    <h1>Express Checkout</h1>
                    @if(Cart::count() > 0)
                        <p>Merci de remplir les informations ci-dessous</p>
                    @endif
                </div>@if(Cart::count() > 0)
                    <div class="col-sm-4 billing">
                        <div class="checkout-header">
                            <strong style="text-transform: uppercase !important;"><span>1.</span> Adresse de facturation</strong>
                            <ul>
                                <li><label>Prénom : <b>*</b></label><input name="billing_first_name" type="text" value="" required onkeyup="validateField(this)" /><em>Merci de remplir le champ</em></li>
                                <li><label>Nom : <b>*</b></label><input name="billing_last_name" type="text" value="" required onkeyup="validateField(this)" /><em>Merci de remplir le champ</em></li>
                                <li><label>Société : </label><input name="billing_company" type="text" value="" /></li>
                                <li><label>Adresse email : <b>*</b></label><input name="billing_email" type="text" value="" required onkeyup="validateField(this)" /><em>Merci de remplir le champ</em></li>
                                <li><label>Téléphone : <b>*</b></label><input name="billing_phone" type="text" value="" required onkeyup="validateField(this)" /><em>Merci de remplir le champ</em></li>
                                <li><label>Adresse : <b>*</b></label><input name="billing_address" type="text" value="" required onkeyup="validateField(this)" /><!--input name="billing_billing2" type="text" /--><em>Merci de remplir le champ</em></li>
                                <li><label>Ville : <b>*</b></label><input name="billing_city" type="text" value="" required onkeyup="validateField(this)" /><em>Merci de remplir le champ</em></li>
                                <li><label>Code postal : <b>*</b></label><input name="billing_zip" type="text" value="" required onkeyup="validateField(this)" /><em>Merci de remplir le champ</em></li>
                                <li><label>Pays : <b>*</b></label><select name="billing_country"><option value="France">France</option><option value="Belgique">Belgique</option><option value="Suisse">Suisse</option></select><em>Merci de remplir le champ</em></li>
                                <li><input id="shippingAddress" name="shippingAddress" type="checkbox" value="1" checked /><label for="shippingAddress">Expédier a la même adresse</label><em>Merci de remplir le champ</em></li>
                            </ul>
                            <ul class="shipping-address">
                                <li><label>Prénom : <b>*</b></label><input name="shipping_first_name" type="text" value="" required onkeyup="validateField(this)" /><em>Merci de remplir le champ</em></li>
                                <li><label>Nom : <b>*</b></label><input name="shipping_last_name" type="text" value="" required  onkeyup="validateField(this)" /><em>Merci de remplir le champ</em></li>
                                <li><label>Société : </label><input name="shipping_company" type="text" value="" /></li>
                                <li><label>Téléphone : <b>*</b></label><input name="shipping_phone" type="text" value="" required onkeyup="validateField(this)" /><em>Merci de remplir le champ</em></li>
                                <li><label>Adresse : <b>*</b></label><input name="shipping_address" type="text" value="" required onkeyup="validateField(this)" /><!--input name="shipping_billing2" type="text" value="" /--><em>Merci de remplir le champ</em></li>
                                <li><label>Ville : <b>*</b></label><input name="shipping_city" type="text" value="" required /><em>Merci de remplir le champ</em></li>
                                <li><label>Code postal : <b>*</b></label><input name="shipping_zip" type="text" value="" required /><em>Merci de remplir le champ</em></li>
                                <li><label>Pays : </label><select name="shipping_country"><option value="France">France</option><option value="Belgique">Belgique</option><option value="Suisse">Suisse</option></select></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4 shipping">
                        <div class="checkout-header shipping-select">
                            <strong style="text-transform: uppercase !important;"><span>2.</span> Choix de livraison</strong>
                            <ul>
                                <li data-value="6.90" @if(App\Shipping::shipping()['id'] == 1) class="active" @endif>
                                    <input id="shipping1" name="shipping" type="radio" value="1" @if(App\Shipping::shipping()['id'] == 1) checked @endif />
                                    <label for="shipping1">Livraison 48-72h :<br /><small>Livré par Colissimo <span>6.90</span>€</small><br /><em>Livré chez vous le: <?php echo $deliver_date2 ?></em></label>
                                    <input type="hidden" name="shipp_delivred_date_o" value=".."></li>
                                <li data-value="10.90" @if(App\Shipping::shipping()['id'] == 2) class="active" @endif>
                                    <input id="shipping2" name="shipping" type="radio" value="2" @if(App\Shipping::shipping()['id'] == 2) checked @endif />
                                    <label for="shipping2">Livraison 24h :<br ><small>Livré par Chronopost, remis contre signature <span>10.90</span>€</small><br /><em>Livré chez vous le: <?php echo $deliver_date1 ?></em></label>
                                    <input type="hidden" name="shipp_delivred_date_t" value="..">
                                </li>
                            </ul>
                        </div>
                        <div class="checkout-header payment">
                            <strong style="text-transform: uppercase !important;"><span>3.</span> Paiement par <em>Carte de crédit</em></strong>
                            <ul>
                                <li>
                                    <input id="cc" name="payment" type="radio" value="1" checked />
                                    <label for="cc" style="text-transform: uppercase !important;">Carte de crédit</label>
                                </li>
                                <li>
                                    <input id="paypal" name="payment" type="radio" value="2" />
                                    <label for="paypal" style="text-transform: uppercase !important;">Paypal</label>
                                </li>
                                <li>
                                    <input id="vb" name="payment" type="radio" value="3" />
                                    <label for="vb" style="text-transform: uppercase !important;">Virement Bancaire</label>
                                    <div class="payment-info">
                                        <strong> Effectuez votre paiement directement depuis votre compte bancaire. Veuillez utiliser votre n° de commande comme référence de paiement. Votre commande ne sera livrée qu’à réception des fonds sur notre compte.</strong>
                                    </div>
                                </li>
                                <li>
                                    <input id="cheque" name="payment" type="radio" value="4" />
                                    <label for="cheque" style="text-transform: uppercase !important;">Chèque</label>
                                    <div class="payment-info">
                                        <strong> Merci de bien vouloir envoyer votre chèque à : <br>
                                            Silver Stone Monaco, <br>
                                            « Service Comptabilité » <br>
                                            48 Boulevard du Jardin Exotique, <br>
                                            98000, Monte Carlo.</strong>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="hidden-xs" style="height: 237px;">&nbsp;</div>
                    </div>
                    <div class="col-sm-4 review">
                        <div class="checkout-header">
                            <strong style="text-transform: uppercase !important;"><span>4.</span> Récapitulatif de votre commande</strong>
                        </div>
                        <div class="products">
                            @foreach(Cart::content() as $row)
                                <ul>
                                    <li><img src="{{ preg_replace("/^http:/i", "https:", $row->image) }}" alt="" /></li>
                                    <li><a>{{ $row->name }}</a><br /><small>Ref: {{ $row->ref }}</small><br /><small>Qty:<select name="qty"><option value="1" @if($row->qty == 1) selected @endif>1</option><option value="2" @if($row->qty == 2) selected @endif>2</option><option value="3" @if($row->qty == 3) selected @endif>3</option><option value="4" @if($row->qty == 4) selected @endif>4</option><option value="5" @if($row->qty == 5) selected @endif>5</option><option value="6" @if($row->qty == 6) selected @endif>6</option><option value="7" @if($row->qty == 7) selected @endif>7</option><option value="8" @if($row->qty == 8) selected @endif>8</option><option value="9" @if($row->qty == 9) selected @endif>9</option><option value="10">10</option></select></small><a href="{{ route("cart.remove", ["rowId" => $row->rowId,"redirect" => 2]) }}" class="remove">{{ my_format(httottc($row->price)) }}€ <i class="fa fa-times"></i></a><input name="id" type="hidden" value="{{$row->rowId}}" /></li>
                                </ul>
                            @endforeach
                        </div>
                        <div class="totals">
                            <ul>
                                <li data-value="{{my_format(Cart::subtotal() + Cart::tax())}}">Total de mes articles (TTC) <span>{{my_format(Cart::subtotal() + Cart::tax())}}€</span></li>
                                <li data-value="{{App\Shipping::shipping()['total']}}">@if(App\Shipping::shipping()['id'] == 1) Livraison 48-72h  @else Livraison 24h @endif <span>{{App\Shipping::shipping()['total']}}€</span></li>
                                <li data-value="{{my_format(Cart::total())}}"> <span>{{my_format(Cart::total() + App\Shipping::shipping()['total'])}}€</span></li>
                            </ul>
                        </div>
                        <div class="promo">
                            <input id="promo" name="promo-select" type="checkbox" value="1" /><label for="promo"> Vous avez un code promo ?</label>
                            <fieldset>
                                <input name="promo" type="text" value="" placeholder="Promo code" />
                                <button>OK</button>
                                <p>Code promo incorrect</p>
                            </fieldset>
                        </div>
                        <div class="conditions">
                            <input name="conditions" type="checkbox" value="" /><a href="{{ route("conditions") }}" target="_blank">J’accepte les Conditions Générales de Vente</a>
                            <span>Vous devez acceptez les conditions générales de vente !</span>
                        </div>
                        <div class="order">
                            <strong>Confirmer et payer maintenant :</strong>
                            <button type="submit">Confirmer votre commande</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </form>
    <script>
        $(function(){
            $('.billing input').focusout(function(){
                if($(this).val() != "") {
                    var billingField = $(this);
                    var billingFieldName = billingField.attr('name');
                    var shippingFieldName = billingFieldName.replace("billing", "shipping");
                    var shippingField = $('input[name='+shippingFieldName+']');
                    var field = $(this);
                    var billingFieldName = field.attr('name');
                    var shippingFieldName = billingFieldName.replace("billing", "shipping");

                    if(shippingField.val() == "") {
                        shippingField.val(billingField.val());
                    }
                }
            });
        });
    </script>
@endsection