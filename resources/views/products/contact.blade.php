@extends('layouts.application.template')

@section('title', 'Page de contact')

@section('content')

<script src='https://www.google.com/recaptcha/api.js'></script>

<div class="container contact">
    <div class="row">
        <div class="col-sm-3">
            <div class="bloc_side_v2 bloc_side_v2_delivery">
                    <p class="title">Livraison Rapide</p>
                    <p><span class="span1">sous</span> <span class="span2">48h</span></p>
            </div>
            <div class="bloc_side_v2 bloc_side_v2_payment">
                <p class="title">Paiement sécurisé</p>
            </div>
            <div class="reviews">
                <div class="trustpilot-widget" data-locale="fr-FR" data-template-id="539ad60defb9600b94d7df2c" data-businessunit-id="514dbc3c000064000524c7e3" data-style-height="500px" data-style-width="100%" data-stars="5">
                </div> 
            </div>
        </div>
        <div class="col-sm-8">
            <div class="form">
                <?php if(!isset($_GET['ref']) || isset($_GET['ref']) && $_GET['ref'] != 1){ ?>
                <p>Aucun appareil ne correspond à votre recherche.<br><b>Vérifiez les références de votre appareil (marque, modèle)</b><br>Si le problème persiste, vous pouvez nous contacter en remplissant le questionnaire ci-dessous :</p>
                <?php } ?>
                    <p>Vous ne trouvez pas votre pièces ou la référence de votre appareil ?
                    <p style="color:#486d97">&#x279C; Appelez nous avec les références de votre appareil sous les yeux
                        <br>Notre équipe de techniciens va vous assister dans vos recherches :
                        <br><div class="phone-icon" style="font-size: 15px;font-weight: bold">Besoin d'aide :
                        <img src="{{ asset("assets/front/img/phone-icone.png") }}"> 0 899 253 057 (Service Commercial 0,80€/min)
                        </div>
                    du lundi au vendredi : de 8h30 à 20h
                    <p><br>Allo Éléctromenager s'engage a vous aider, vous pouvez nous contacter en remplissant le questionnaire ci-dessous :</p>

                    <form action="" method="POST" novalidate>
                    <fieldset>
                        <label>La référence de votre appareil<span>*</span></label>
                        <input name="reference" type="text" value="" onkeyup="validateContactField(this)" required />
                    </fieldset>
                    <fieldset>
                        <label>La marque de votre appareil<span>*</span></label>
                        <input name="brand" type="text" value="" onkeyup="validateContactField(this)" required />
                    </fieldset>
                    <fieldset>
                        <label>Le type de votre appareil<span>*</span></label>
                        <input name="type" type="text" value="" onkeyup="validateContactField(this)" required  />
                    </fieldset>
                    <fieldset>
                        <label>Votre message<span>*</span></label>
                        <textarea name="message" onkeyup="validateContactField(this)" required ></textarea>
                    </fieldset>
                    <fieldset>
                        <label>Votre email<span>*</span></label>
                        <input name="email" type="text" value="" onkeyup="validateContactField(this)" required />
                    </fieldset>
                    <fieldset>
                        <label>Votre Téléphone<span>*</span></label>
                        <input name="phone" type="text" value="" onkeyup="validateContactField(this)" required />
                    </fieldset>
                    <fieldset>
                        <p class="error">Veuillez cocher le captcha</p>
                        <div class="g-recaptcha" data-sitekey="6Lcg7RgUAAAAAIXNTiNB6acIXLELw_4uX1tNd1h0"></div>
                    </fieldset>
                    <fieldset>
                        {{ csrf_field() }}
                        <button>Envoyer</button>
                    </fieldset>
                </form>
                <div class="form-success">
                    <p><strong> Merci pour votre message. Il a bien été envoyé.</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection