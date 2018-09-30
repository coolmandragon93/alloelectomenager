@extends('layouts.application.template')
@section('title', 'Marques')
@section('content')
    <?php
    $extensions = ['png','jpg','jpeg','gif','JPG'];
    $brandLogo = null;
    foreach($extensions as $key => $value) {
        if(file_exists('assets/front/img/brand/'.$brand.'.'.$extensions[$key])){
            $brandLogo = '/assets/front/img/brand/'.$brand.'.'.$extensions[$key];
        }
    }
    function render_arrow_and_dot($string)
    {
        $string = str_replace("(@arrow)", "<img width='18px' src='" . asset('assets/front/img/frontend/Etiquette_Arrow.png') . "' />", $string);
        $string = str_replace("(@dot1)", "<img width='18px' src='" . asset('assets/front/img/frontend/Etiquette_Num1.png') . "' />", $string);
        $string = str_replace("(@dot2)", "<img width='18px' src='" . asset('assets/front/img/frontend/Etiquette_Num2.png') . "' />", $string);
        $string = str_replace("(@dot3)", "<img width='18px' src='" . asset('assets/front/img/frontend/Etiquette_Num3.png') . "' />", $string);
        return $string;
    }
    ?>
    <div class="container">
        <div class="row">
            <div class=" col-sm-12 col-md-9">
                <div class="brand">
                    <div class="brand-logo">
                        <img src="<?php echo $brandLogo ?>" alt="Logo" />
                    </div>
                    <div class="brand-text">
                        <h1>Pièces détachées électromenager <strong><?php echo strtoupper($brand); ?></strong></h1>
                        <p>Entrez la référence de votre appareil <strong><?php echo strtoupper($brand); ?></strong></p>
                        <form method="get" action="{{ route("search_appliance") }}">
                            <div class="form-group">
                                <input type="text" class="form-control" name="serial" id="serial" placeholder="XXX-XXX-XXX">
                                <input type="hidden" class="form-control" name="manufacturer" value="<?php echo $brand ?>">
                                <button type="submit" class="btn btn-primary">Trouvez votre pièce</button>
                            </div>
                        </form>
                        <a href="#" class="scrollto"><p>Besoin d'aide dans la recherche ?</p></a>
                        <script>$(".scrollto").click(function() {
                                $('html,body').animate({
                                        scrollTop: $(".spares").offset().top},
                                    'slow');
                            });</script>
                    </div>
                    @if(count($brandProducts) > 0)
                        <div class="reference-label">
                            <h2>Pièces détachées <?php echo strtoupper($brand); ?> les plus vendues</h2>
                        </div>
                        <div class="reference-brandProd">
                            <?php $i = 1; ?>
                            @foreach($brandProducts as $product)
                                <div class="brandProd col-xs-6 col-sm-3 col-md-2">
                                    <div class="brandProd-img">
                                        <a href="{{ route('singleProduct', [$brand, $product['artikelnummer']]) }}"><img src="<?php if(isset($product['img_url']['tempurl'])){ echo $product['img_url']['tempurl']; }else{ echo '/img/no_img_avaliable.jpg'; }?>" alt="Image non disponible" /></a>
                                    </div>
                                    <div class="brandProd-content">
                                        <strong>{{ $product['artikelbezeichnung'] }}</strong>
                                        <p>
                                        {{ $product['price'] }}
                                   €</p>
                                    </div>
                                </div>
                                @if($i % 2 == 0)
                                    <div class="clearfix visible-xs-block"></div>
                                @endif
                                <?php $i++; ?>
                            @endforeach
                        </div>
                    @endif
                    <div class="reference-label spares">
                        <h2>Trouver la référence de votre pièce <?php echo strtoupper($brand); ?> </h2>
                    </div>
                    <div class="reference">
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-3" data-index="0" data-title="Où trouver la référence de votre micro onde ?"><img class="img-responsive" style="height: 100px;" src="{{ asset("assets/front/img/frontend/micro-ondes.png") }}" alt="Four a micro-onde" /><br /><strong><h3 style="font-size: 16px !important;">Four a micro-onde</h3></strong></div>
                            <div class="col-xs-4 col-sm-4 col-md-3" data-index="1" data-title="Où trouver la référence de votre lave linge ?"><img class="img-responsive" style="height: 100px;" src="{{ asset("assets/front/img/menu/lave-linge.png") }}" alt="Lave-linge" /><br /><strong><h3 style="font-size: 16px !important;">Lave-linge</h3></strong></div>
                            <div class="col-xs-4 col-sm-4 col-md-3" data-index="2" data-title="Où trouver la référence de votre lave vaisselle ?"><img class="img-responsive" style="height: 100px;" src="{{ asset("assets/front/img/menu/lave-vaisselle.png") }}" alt="Lave-vaisselle" /><br /><strong><h3 style="font-size: 16px !important;">Lave-vaisselle</h3></strong></div>
                            <div class="col-xs-4 col-sm-4 col-md-3" data-index="3" data-title="Où trouver la référence de votre appareil de cuisson ?"><img class="img-responsive" style="height: 100px;" src="{{ asset("assets/front/img/menu/four.png") }}" alt="Cuisson" /><br /><strong><h3 style="font-size: 16px !important;">Cuisson</h3></strong></div>
                            <div class="col-xs-4 col-sm-4 col-md-3" data-index="4" data-title="Où trouver la référence de votre machine a cafe ?"><img class="img-responsive" style="height: 100px;" src="{{ asset("assets/front/img/frontend/moulinex_bouilloir.png") }}" alt="Machine à café" /><br /><strong><h3 style="font-size: 16px !important;">Machine à café</h3></strong></div>
                            <div class="col-xs-4 col-sm-4 col-md-3" data-index="5" data-title="Où trouver la référence de votre petit electromenager ?"><img class="img-responsive" style="height: 100px;" src="{{ asset("assets/front/img/frontend/philips_gc2040_easyplus.png") }}" alt="Petit électroménager" /><br /><strong><h3 style="font-size: 16px !important;">Petit électroménager</h3></strong></div>
                            <div class="col-xs-4 col-sm-6 col-md-3" data-index="6" data-title="Où trouver la référence de votre réfrigerateur ?"><img class="img-responsive" style="height: 100px;" src="{{ asset("assets/front/img/frontend/refrigerateur.png") }}" alt="Réfrigérateur" /><br /><strong><h3 style="font-size: 16px !important;">Réfrigérateur</h3></strong></div>
                            <div class="col-xs-4 col-sm-6 col-md-3" data-index="7" data-title="Où trouver la référence de votre aspirateur ?"><img class="img-responsive" style="height: 100px;" src="{{ asset("assets/front/img/frontend/aspirateur.png") }}" alt="Aspirateur" /><br /><strong><h3 style="font-size: 16px !important;">Aspirateur</h3></strong></div>
                        </div>
                        <div class="reference-text">
                            <strong>Où trouver la référence de votre micro-onde ?</strong>
                        </div>
                        <div class="reference-dynamic">
                            <div class="ref">
                                <img src="{{ asset("assets/front/img/reference1.jpg") }}" alt="Reference micro-onde" />
                                <p>La fiche technique pour ce type d’électroménagers, ce situe en permanence au dos de l'appareil.</p>
                            </div>
                            <div class="ref">
                                <img src="{{ asset("assets/front/img/reference5.jpg") }}" alt="Reference lave-linge" />
                                <p>Pour les appareils avec un hublot, la fiche ce trouve sur le côté intérieur du hublot ou au dos de l'appareil.<br />Pour les autres types d'appareils, dans le clapet du bouchon de pompe, derriere le cache du dessous et derrière l'appareil.</p>
                            </div>
                            <div class="ref">
                                <img src="{{ asset("assets/front/img/reference0.jpg") }}" alt="Reference lave-vaisselle" />
                                <p>La fiche technique se trouve dans le clapet du bouchon de pompe, derriere le cache du dessous ou derrière l'appareil.</p>
                            </div>
                            <div class="ref">
                                <img src="{{ asset("assets/front/img/reference6.jpg") }}" alt="Reference cuisson" />
                                <p>Au dos de l'appareil ou sur les côtés de l'appareil <br />Sur la partie intérieure de la porte du four <br />Sur la partie inférieure du charriot roulant</p>
                            </div>
                            <div class="ref">
                                <img src="{{ asset("assets/front/img/reference4.jpg") }}" alt="Reference machine a cafe" />
                                <p>La fiche technique pour ce type d’électroménagers, ce situe en permanence au dos de l'appareil.</p>
                            </div>
                            <div class="ref">
                                <img src="{{ asset("assets/front/img/reference2.jpg") }}" alt="Reference petit electromenager" />
                                <p>La fiche technique pour ce type d’électroménagers, ce situe en permanence au dos de l'appareil ou sur la partie inférieure.</p>
                            </div>
                            <div class="ref">
                                <img src="{{ asset("assets/front/img/reference3.png") }}" alt="Reference refrigerateur" />
                                <p>A l'interieur de l'appareil au niveau du bac à légumes<br /> Sur une paroie de l'appareil<br />Au dos de l'appareil</p>
                            </div>
                            <div class="ref">
                                <img src="{{ asset("assets/front/img/reference7.jpg") }}" alt="Reference aspirateur" />
                                <p>La fiche technique pour ce type d’électroménagers, ce situe en permanence au dos de l'appareil.</p>
                            </div>
                        </div>
                        <div class="reference-text">
                            @if(!$brand_detail->description))
                            <div class="reference-etiquette">
                                <img src="{{ asset("assets/front/img/etiquettes/Etiquette_generique.png") }}" alt="Etiquette de reference" />
                            </div>
                            <div class="reference-points">
                                <p>
                                    La plupart des appareils Electroménager présente une étiquette signalétique qui indique les références de l'appareil.<br /><br />
                                    Dans cette exemple type, Le modèle affiche en <img src="{{ asset("assets/front/img/frontend/Etiquette_Num1.png") }}" alt="Etiquette num 1"> est UE40B6000VW.
                                    La référence du modèle est souvent une combinaison de chiffres et de lettres.<br /><br />
                                    Si vous n'arrivez pas à trouver votre pièce détachée à partir de cette référence, essayez le TYPE <img src="{{ asset("assets/front/img/frontend/Etiquette_Num2.png") }}" alt="Etiquette num 2"> ou le CODE <img src="{{ asset("assets/front/img/frontend/Etiquette_Num3.png") }}" alt="Etiquette num 3"></p>
                            </div>
                            @else
                                {!! render_arrow_and_dot($brand_detail->description) !!}
                            @endif
                        </div>
                        <div class="reference-text blue">
                            <p><a href="{{ url("contact?ref=1") }}">Vous ne trouvez pas votre référence ? N'hésitez pas a contacter AlloElectromenager, nous vous guiderons dans la démarche</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @include('layouts.application.right_column')
            </div>
        </div>
    </div>
@endsection