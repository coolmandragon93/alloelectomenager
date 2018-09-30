@extends('layouts.application.template')

@section('title', 'Vente Pièces Détachées électroménager et Accessoires')
@section('keywords', 'piece, bosch, whirlpool, pièces détachées, LG, samsung, miele, scholtes, braun, brandt, calor, delonghi, dyson, electrolux, hoover, kenwood, krups, moulinex, rowenta, four, detachee, remplacer pièce, piece electromenager hotte, plaque, menager, appareil')
@section('description', ' ➽ Spécialiste Pièces Détachées électroménager et accessoires électroménager, remplacer pièce ✅Lave-linge ✅Sèche-linge ✅Lave-vaiselle ✅Four... ✅Toutes marques ✱Livrée sous 24h/48h❗✱')
@section('robots', 'INDEX,FOLLOW')

@section('content')

    <div class="container">
        <div class="row">
            <br> <div style="color: grey;"><h1 style="font-size:12px !important;">Ventes de pièces detachées en ligne</h1></div>
            <div class="col-md-9">
                <div class="row main-search">
                    <div class="col-sm-12">
                        <h2 style="font-size: 14px !important;" class="main-title" title="Une fois que vous avez trouvé la référence de votre appareil Electroménager dans notre moteur de recherche, choisissez ensuite votre type de pièce">Recherche par référence</h2>
                    </div>
                    <div class="col-sm-4">
                        <img src="{{ asset("assets/front/img/frontend/group-of-home-appliances-isolated-on-white-background.png") }}" alt="Image de diverse pièces detachées" class="img-responsive">
                    </div>
                    <div class="col-sm-8">
                        <form method="get" class="search-form" action="{{ route('search_appliance') }}">
                            <div class="form-group">
                                <label for="serial">Entrez la référence de votre appareil</label>
                                <input 
																	type="text" 
																	class="form-control" 
																	name="serial" 
																	id="serial" 
																	placeholder="Référence de mon appareil, de ma pièce..."
																/>
                            </div>
                            <div class="form-group">
                                <label for="manufacturer">Marque (optionnel)</label>
                                <input type="text" class="form-control" name="manufacturer" id="manufacturer" placeholder="Xxxxx" style="width: 200px;">
                            </div>
                            <div class="text-right">
                                <button style="bottom: 15px;" type="submit" class="btn btn-primary">Trouvez votre pièce</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row_2">
                </div>
                <div class="row manufacturers">
                    <div class="col-md-12 second-title title-homepage">
                        <h4>Fabricants</h4>
                    </div>
                    <div class="brands">
                        <div class="brand-slider">
                            @for ($i = 0; $i < count($brands); $i += 2)
                                <div class="brand">
                                    <a href="{{ route("brands", str_slug($brands[$i]->name), '-') }}"><img width="128" height="58" src="{{ asset("assets/front/img/brand/" . str_replace(" ", '-', $brands[$i]->name) . ".png") }}" alt="{{$brands[$i]->name}}" /></a>

                                    @if (isset($brands[$i + 1]))
                                        <a href="{{ route("brands", str_slug($brands[$i + 1]->name), '-') }}"><img width="128" height="58" src="{{ asset("assets/front/img/brand/" . str_replace(" ", '-', $brands[$i + 1]->name) . ".png") }}" alt="{{$brands[$i + 1]->name}}" /></a>
                                    @endif
                                </div>
                            @endfor
                        </div>    
                    </div>
                    <div class="brand-dots">
                        <ul>

                        </ul>
                    </div>
                </div>
                <div class="row how-it-works">
                    <div class="col-md-12 second-title title-homepage">
                        <h4>Comment ça marche ?</h4>
                    </div>
                    <div class="col-md-3" style="color: #F26021">
                        <img src="{{ asset("assets/front/img/frontend/Etiquette_generique.png") }}" alt="Etiquette generique" class="img-responsive">
                        <strong style="top: 100%">1. RENSEIGNEZ La référence de votre appareil et lancer la recherche</strong>
                    </div>
                    <div class="col-md-3" style="color: #F26021">
                        <img src="{{ asset("assets/front/img/frontend/liste_pieces_detachee.png") }}" alt="Pieces detachée" class="img-responsive">
                        <strong>2. Cliquez sur "liste des pieces détachées"</strong>
                    </div>
                    <div class="col-md-3" style="color: #F26021">
                        <img src="{{ asset("assets/front/img/frontend/group_article.png") }}" alt="Groupe d'article" class="img-responsive">
                        <strong>3. Choisir le type de pièce dans la liste</strong>
                    </div>
                    <div class="col-md-3" style="color: #F26021">
                        <img src="{{ asset("assets/front/img/frontend/votre_piece.png") }}" alt="Votre pièce" class="img-responsive">
                        <strong>4. Cliquez sur votre pièce</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="reference-label">
                    <h2>Trouvez la référence de votre piéce detachée</h2>
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
                        <strong></strong>
                    </div>
                    <div class="reference-dynamic">
                        <div class="ref">
                            <img src="{{ asset("assets/front/img/reference1.jpg") }}" alt="Etiquette 1" />
                            <p>La fiche technique pour ce type d’électroménagers, ce situe en permanence au dos de l'appareil.</p>
                        </div>
                        <div class="ref">
                            <img src="{{ asset("assets/front/img/reference5.jpg") }}" alt="Etiquette 2" />
                            <p>Pour les appareils avec un hublot, la fiche ce trouve sur le côté intérieur du hublot ou au dos de l'appareil.<br /><br />Pour les autres types d'appareils, dans le clapet du bouchon de pompe, derriere le cache du dessous et derrière l'appareil.</p>
                        </div>
                        <div class="ref">
                            <img src="{{ asset("assets/front/img/reference0.jpg") }}" alt="Etiquette 3" />
                            <p>La fiche technique se trouve dans le clapet du bouchon de pompe, derriere le cache du dessous ou derrière l'appareil.</p>
                        </div>
                        <div class="ref">
                            <img src="{{ asset("assets/front/img/reference6.jpg") }}" alt="Etiquette 4" />
                            <p>Au dos de l'appareil ou sur les côtés de l'appareil <br /><br />Sur la partie intérieure de la porte du four <br /><br />Sur la partie inférieure du charriot roulant</p>
                        </div>
                        <div class="ref">
                            <img src="{{ asset("assets/front/img/reference4.jpg") }}" alt="Etiquette 5" />
                            <p>La fiche technique pour ce type d’électroménagers, ce situe en permanence au dos de l'appareil.</p>
                        </div>
                        <div class="ref">
                            <img src="{{ asset("assets/front/img/reference2.jpg") }}" alt="Etiquette 6" />
                            <p>La fiche technique pour ce type d’électroménagers, ce situe en permanence au dos de l'appareil ou sur la partie inférieure.</p>
                        </div>
                        <div class="ref">
                            <img src="{{ asset("assets/front/img/reference3.png") }}" alt="Etiquette 7" />
                            <p>A l'interieur de l'appareil au niveau du bac à légumes<br /><br /> Sur une paroie de l'appareil<br /><br />Au dos de l'appareil</p>
                        </div>
                        <div class="ref">
                            <img src="{{ asset("assets/front/img/reference7.jpg") }}" alt="Etiquette 8" />
                            <p>La fiche technique pour ce type d’électroménagers, ce situe en permanence au dos de l'appareil.</p>
                        </div>
                    </div>
                    <div class="reference-text">
                        <div class="reference-etiquette">
                            <img src="{{ asset("assets/front/img/frontend/Etiquette_generique.png") }}" alt="Etiquette generique" />
                        </div>
                        <div class="reference-points">
                            <p>La plupart des appareils Electroménager présente une étiquette signalétique qui indique les références de l'appareil.<br /><br />Dans cette exemple type, Le modèle affiché en <img src="/assets/front/img/frontend/Etiquette_Num1.png" alt="Etiquette num 1"> est UE40B6000VW. La référence du modèle est souvent une combinaison de chiffres et de lettres.<br /><br />Si vous n'arrivez pas à trouver votre pièce détachée à partir de cette référence, essayez le TYPE <img src="/assets/front/img/frontend/Etiquette_Num2.png" alt="Etiquette num 2"> ou le CODE <img src="/assets/front/img/frontend/Etiquette_Num3.png" alt="Etiquette num 3"></p>
                        </div>
                    </div>
                    <div class="reference-text blue">
                        <p><a href="{{ action('ProductsController@contact', ['ref' => 1]) }}">Vous ne trouvez pas votre référence ? N'hésitez pas a contacter AlloElectromenager, nous vous guiderons dans la démarche</a></p>
                    </div>
                </div>
                    <div class="row white">
                        <div class="col-xs-12 col-sm-12 home-intro">
                            <p>Aujourd'hui la maison équipée de vos rêves est à portée de main, avec cinq cents millions d’appareils équipant à l’heure actuelle les foyers Français, dont 190 millions de gros électroménager et 310 millions de petit électroménager le choix est a porté de main ! Mais pourquoi toujours changer vos produits défectueux, avec plus de 11 millions de pièces détachées électroménager et d'accessoires, AlloElectromenager vous aide dans la réparation de votre précieuse cuisinière, de votre télévision préférée ainsi que votre machine à café indispensable pour surmonter vos journées !</p>
                            <p class="center"><a href="#" class="more"><span>Voir plus</span><br /><i class="fa fa-angle-down"></i></a></p>
                            <p class="more-content">Avec notre moteur de recherche intuitif et efficace, renseigner la marque et la référence de votre appareil, vous trouverez nos plus grandes marques tels-que Dyson, Bosch, Whirlpool, LG, Philips, Samsung, Rowenta, etc. Des pièces de qualité et durables, qui vous permettrons de changer la ROULETTE PANIER de votre lave-vaisselle Bosch, la POIGNEE DE HUBLOT de votre lave-linge Brandt, la BROSSE SOL DUR de votre aspirateur Dyson, le PLATEAU TOURNANT de votre micro-ondes Samsung. AlloElectromenager met à votre disposition notre catalogue de produits et notre expertise pour vous accompagner tout le long de votre réparation !   Chez AlloElectromenager, on est tous très attentionné a l'environnement, nous essayons de mettre fin à l’obsolescence programmée en passant du Jetable au Durable !<br />Certes il n'est pas toujours facile de bricoler quand on est novice ! Mais celles et ceux désireux d’apprendre à se débrouiller par eux-mêmes peuvent faire confiance à AlloElectromenager, avec ses nombreux Tutoriels "Do it yourself" votre climatisation ou votre réfrigérateur n'aurons plus de secrets ! Ne plus racheter systématiquement et prolonger la durée de vie votre appareil par le biais de nouvelles pièces détachées c'est faire des économies et aussi réduire la quantité de CO² et de déchets est c'est aussi ça notre objectif chez AlloElectromenager</p><p>Pour toute demande de références ou conseil, n’hésitez pas à nous contacter directement par téléphone au 08 99 25 30 57<br />Toute pièce détachée d'électroménager livrée dans les 48h après commande !<br />«Do It Yourself» du Jetable au Durable c'est facile avec AlloElectromenager!<br />Un peu d'huile de coude, l'expertise d'AlloElectromenager et le tour est joué !<br /><br />Ce que pensent les particuliers du système «Do It Yourself»<br /><br />«Je pense que j'ai économisé 200 à 300 euros à chaque fois» Un habitué<br /><br />«Cela ne prend pas beaucoup de temps et on se sent fière de soi ! Si j’avais dû faire appel à un technicien, cela m’aurait coûté dans les 100 euros alors que là j’ai juste eu à acheter la pièce détachée». Camille H.</p>
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