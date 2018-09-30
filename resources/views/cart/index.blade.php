@extends('layouts.application.template')

@section('title', 'Panier')

@section('content')

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

    $current_time = date("H:i");
    $start = "00:00 am";
    $end = "15:00 pm";
    $date1 = DateTime::createFromFormat('H:i a', $current_time);
    $date2 = DateTime::createFromFormat('H:i a', $start);
    $date3 = DateTime::createFromFormat('H:i a', $end);
    if ($date1 < $date2)
    {
        $next_day_num1 = $highestDate + 3;
        $next_day_num2 = $highestDate + 5;
    }
    else {
        $next_day_num1 = $highestDate + 2;
        $next_day_num2 = $highestDate + 5;
    }



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

    <div class="container cart">
        <div class="row">
            <div class="col-md-9 col-content">
                <div class="cart-title">
                    <h1>Panier</h1>
                </div>
                @if(Cart::count() > 0)
                    <div class="cart-labels">
                        <ul>
                            <li>Produit</li>
                            <li>Quantité</li>
                            <li>Prix Unitaire TTC</li>
                            <li>Total</li>
                        </ul>
                    </div>
                    <div class="cart-products">
                        @foreach(Cart::content() as $row)
                            <ul>
                                <li><img src="{{ $row->image }}" alt="" /><a>{{ $row->name }}</a><br /><small>Ref: {{ $row->ref }}</small></li>
                                <li><a href="{{ route("cart.update", ["rowId" => $row->rowId,"qty" => ($row->qty - 1)]) }}"><i class="fa fa-minus"></i></a><input name="qty" type="text" value="{{ $row->qty }}" readonly><a href="{{ route("cart.update", ["rowId" => $row->rowId,"qty" => ($row->qty + 1)]) }}"><i class="fa fa-plus"></i></a></li>
                                <li><span>{{ my_format(httottc($row->price)) }}€</span></li>
                                <li><span>{{ my_format($row->total) }}€</span></li>
                                <li><a href="{{ route("cart.remove", ["rowId" => $row->rowId]) }}"><i class="fa fa-times"></i></a></li>
                            </ul>
                        @endforeach
                    </div>
                    <div class="cart-shipping">
                        <strong>Choisir votre mode de livraison :</strong>
                        <ul>
                            <li @if(App\Shipping::shipping()['id'] == 1) class="active" @endif>
                                <input id="shipping1" name="shipping" type="radio" value="1" data-redirect="1" @if(App\Shipping::shipping()['id'] == 1) checked @endif />
                                <label for="shipping1"><i></i>Livraison 48-72h :<br /><small>Livré par Colissimo 6,90€</small><br /><span>Livré chez vous le: <?php echo $deliver_date2;  ?></span></label>
                            </li>
                            <li @if(App\Shipping::shipping()['id'] == 2) class="active" @endif>
                                <input id="shipping2" name="shipping" type="radio" value="2" data-redirect="1" @if(App\Shipping::shipping()['id'] == 2) checked @endif />
                                <label for="shipping2"><i></i>Livraison 24h :<br ><small>Livré par Chronopost, remis contre signature 10,90€</small><br /><span>Livré chez vous le: <?php echo $deliver_date1; ?></span></label>
                            </li>
                        </ul>
                    </div>
                    <div class="cart-details">
                        <a href="#">Vous avez un code promo ?</a>
                        <fieldset>
                            <input name="promo" type="text" value="" placeholder="Promo code" />
                            <button>OK</button>
                            <p>Code promo incorrect</p>
                        </fieldset>
                        <ul>
                            <li>Total de mes articles (TTC) <span>{{my_format(Cart::subtotal() + Cart::tax())}}€</span></li>
                            <li>@if(App\Shipping::shipping()['id'] == 1) Livraison 48-72h  @else Livraison 24h @endif <span>{{App\Shipping::shipping()['total']}}€</span></li>
                            <li> <span>{{my_format(Cart::total() + App\Shipping::shipping()['total'])}}€</span></li>
                        </ul>
                        <button onclick="document.location.href='/panier/checkout'">Commander</button>
                    </div>
                @endif
                @if(Cart::count() <= 0)
                    <div style="text-align: center">
                        Votre panier est vide.
                    </div>
                @endif
                <div style="clear:both"></div>
            </div>
            <div class="col-md-3">
                @include('layouts.application.right_column')
            </div>
        </div>
    </div>

@endsection