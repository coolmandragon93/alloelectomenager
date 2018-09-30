@extends('layouts.application.template')

@section('title', 'Annulation de la commande')

@section('content')

<div class="container info">
    <div class="row">
        <div class="col-sm-12 col-content">
        	<h1>Vous avez annuler votre commande, vous allez être rediriger vers la page d'accueil.</h1>
        </div>
    </div>
</div>

    <script>setTimeout(function () {
            window.location.href= 'https://alloelectromenager.com/'; // the redirect goes here

        },5000); // 5 seconds</script>
@endsection