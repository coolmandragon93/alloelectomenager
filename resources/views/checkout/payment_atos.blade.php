@extends('layouts.application.noHeader')
@section('title', 'Checkout')
@section('content')
    <div class="container checkout top-border">
        <div class="row">
            <div class="col-sm-4">

            </div>
            <div class="col-sm-4 text-center">
                <img src="/assets/front/img/logos/alloelectro.png" alt="AlloElectromenager" class="img-responsive" title="AlloElectromenager">
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
    <div class="container checkout">
        <div class="row">
            <div class="col-sm-12">
                @if($error_message != "")
                <div class="alert alert-danger" role="alert">
                    Une erreur est survenue. Veuillez ressayer plus tard, ou contacter nous si vous rencontrer des difficultés.
                </div>
                @else
                {!! $message !!}
                @endif
            </div>
        </div>
    </div>
@endsection