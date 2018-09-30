@extends('layouts.application.template')

@section('title', 'Résultats de la recherche')

@section('content')

    <?php
        $cur_page = $result['seite'];
        $total_records = $result['gesamtanzahltreffer'];
        $num_rows_per_page = $result['trefferproseite'];

        $num_page = (int)($total_records / $num_rows_per_page) + ($total_records % $num_rows_per_page > 0);

        $page_name = array();
        $left_records = $total_records;
        $page_count = 1;
        while ($left_records > 0)
        {
            $name = ($page_count - 1) * $num_rows_per_page + 1 .'-'.min($left_records, ($page_count - 1) * $num_rows_per_page + $num_rows_per_page);
            $from_record = ($page_count - 1) * $num_rows_per_page + 1;
            $to_record = min($left_records + $from_record, $num_rows_per_page + $from_record) - 1;

            array_push($page_name, $from_record .'-'. $to_record);

            $page_count++;
            $left_records -= $num_rows_per_page;
        }

        array_push($page_name, 'end');

        // remove special characters
    $serial = preg_replace("/[\/\s+]/", '', $request->serial);
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <ol class="breadcrumb">
                    <li>
                        <a href="#">Recherche</a>
                    </li>
                    <li class="active"> {{ $serial }}</li>
                </ol>

                <div class="row search-main">
                    <form>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="serial">Entrez la référence de votre appareil</label>
                                <input type="text" class="form-control" name="serial" id="serial" placeholder="XXX-XXX-XXX" value="{{ $serial }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="manufacturer">Marque (optionnel)</label>
                                <input type="text" class="form-control" name="manufacturer" id="manufacturer" placeholder="Xxxxx" value="{{ $request->manufacturer }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Trouvez votre pièce</button>
                        </div>
                    </form>
                    <div class="col-md-12">
                        <p><a href="#">Besoin d'aide dans la recherche ? <i class="fa fa-plus"></i></a></p>
                    </div>
                </div>


                <div class="search-hidden">
                <div class="row">
                    <div class="reference-label">
                    <h2>Trouvez votre référence</h2>
                </div>
                <div class="reference">
                    <div class="reference-list">
                        <ul>
                            <li data-index="0" data-title="Où trouver la référence de votre micro onde ?"><img src="/assets/front/img/frontend/micro-ondes.png" alt=" Four a micro-ondes" /><br /><strong>Four a micro-onde</strong></li>
                            <li data-index="1" data-title="Où trouver la référence de votre lave linge ?"><img src="/assets/front/img/menu/lave-linge.png" alt="Lave-linge" /><br /><strong>Lave-linge</strong></li>
                            <li data-index="2" data-title="Où trouver la référence de votre lave vaisselle ?"><img src="/assets/front/img/menu/lave-vaisselle.png" alt="Lavz-vaisselle" /><br /><strong>Lave-vaisselle</strong></li>
                            <li data-index="3" data-title="Où trouver la référence de votre appareil de cuisson ?"><img src="/assets/front/img/menu/four.png" alt="Cuisson" /><br /><strong>Cuisson</strong></li>
                            <li data-index="4" data-title="Où trouver la référence de votre machine a cafe ?"><img src="/assets/front/img/frontend/moulinex_bouilloir.png" alt="Machine à café" /><br /><strong>Machine à café</strong></li>
                            <li data-index="5" data-title="Où trouver la référence de votre petit electromenager ?"><img src="/assets/front/img/frontend/philips_gc2040_easyplus.png" alt="Petit éléctroménager" /><br /><strong>Petit électroménager</strong></li>
                            <li data-index="6" data-title="Où trouver la référence de votre réfrigerateur ?"><img src="/assets/front/img/frontend/refrigerateur.png" alt="Réfrigérateur" /><br /><strong>Réfrigérateur</strong></li>
                            <li data-index="7" data-title="Où trouver la référence de votre aspirateur ?"><img src="/assets/front/img/frontend/aspirateur.png" alt="Aspirateur" /><br /><strong>Aspirateur</strong></li>
                        </ul>
                    </div>
                    <div class="reference-text">
                        <strong></strong>
                    </div>
                    <div class="reference-dynamic">
                        <div class="ref">
                            <img src="/assets/front/img/reference1.jpg" alt="Etiquette 1" />
                            <p>La fiche technique pour ce type d’électroménagers, ce situe en permanence au dos de l'appareil.</p>
                        </div>
                        <div class="ref">
                            <img src="/assets/front/img/reference5.jpg" alt="Etiquette 2" />
                            <p>Pour les appareils avec un hublot, la fiche ce trouve sur le côté intérieur du hublot ou au dos de l'appareil.<br /><br />Pour les autres types d'appareils, dans le clapet du bouchon de pompe, derriere le cache du dessous et derrière l'appareil.</p>
                        </div>
                        <div class="ref">
                            <img src="/assets/front/img/reference0.jpg" alt="Etiquette 3" />
                            <p>La fiche technique se trouve dans le clapet du bouchon de pompe, derriere le cache du dessous ou derrière l'appareil.</p>
                        </div>
                        <div class="ref">
                            <img src="/assets/front/img/reference6.jpg" alt="Etiquette 4" />
                            <p>Au dos de l'appareil ou sur les côtés de l'appareil <br /><br />Sur la partie intérieure de la porte du four <br /><br />Sur la partie inférieure du charriot roulant</p>
                        </div>
                        <div class="ref">
                            <img src="/assets/front/img/reference4.jpg" alt="Etiquette 5" />
                            <p>La fiche technique pour ce type d’électroménagers, ce situe en permanence au dos de l'appareil.</p>
                        </div>
                        <div class="ref">
                            <img src="/assets/front/img/reference2.jpg" alt="Etiquette 6" />
                            <p>La fiche technique pour ce type d’électroménagers, ce situe en permanence au dos de l'appareil ou sur la partie inférieure.</p>
                        </div>
                        <div class="ref">
                            <img src="/assets/front/img/reference3.png" alt="Etiquette 7" />
                            <p>A l'interieur de l'appareil au niveau du bac à légumes<br /><br /> Sur une paroie de l'appareil<br /><br />Au dos de l'appareil</p>
                        </div>
                        <div class="ref">
                            <img src="/assets/front/img/reference7.jpg" alt="Etiquette 8" />
                            <p>La fiche technique pour ce type d’électroménagers, ce situe en permanence au dos de l'appareil.</p>
                        </div>
                    </div>
                    <div class="reference-text">
                        <div class="reference-etiquette">
                            <img src="/assets/front/img/frontend/Etiquette_generique.png" alt="Etiquette generique" />
                        </div>
                        <div class="reference-points">
                            <p>La plupart des appareils Electroménager présente une étiquette signalétique qui indique les références de l'appareil.<br /><br />Dans cette exemple type, Le modèle affiche en <img src="/assets/front/img/frontend/Etiquette_Num1.png" alt=""> est UE40B6000VW. La référence du modèle est souvent une combinaison de chiffres et de lettres.<br /><br />Si vous n'arrivez pas à trouver votre pièce détachée à partir de cette référence, essayez le TYPE <img src="/assets/front/img/frontend/Etiquette_Num2.png" alt=""> ou le CODE <img src="/assets/front/img/frontend/Etiquette_Num3.png" alt=""></p>
                        </div>
                    </div>
                    <div class="reference-text blue">
                        <p><a href="{{ url("contact?ref=1") }}">Vous ne trouvez pas votre référence ? N'hésitez pas a contacter AlloElectromenager, nous vous guiderons dans la démarche</a></p>
                    </div>
                </div>
                    
                </div>
            </div>


                <div class="pagination">
                    <form class="item {{ $cur_page ==  1 ? 'hide' : '' }} ">
                        <input type="hidden" name="serial" value="{{ $serial }}">
                        <input type="hidden" name="manufacturer" value="{{ $request->manufacturer }}">
                        <input type="hidden" name="page" value="{{ $cur_page - 1 }}">

                        <button type="submit" class="btn btn-primary"> Page précédente</button>
                    </form>

                    <form class="item">
                        <input type="hidden" name="serial" value="{{ $serial }}">
                        <input type="hidden" name="manufacturer" value="{{ $request->manufacturer }}">
                        <input type="hidden" name="page" value="{{ $cur_page  }}">

                        <button disabled type="button" class="btn btn-primary active"> {{ $page_name[$cur_page - 1] }}</button>
                    </form>

                    <form class="item {{ $num_page ==  $cur_page ? 'hide' : '' }} ">
                        <input type="hidden" name="serial" value="{{ $serial }}">
                        <input type="hidden" name="manufacturer" value="{{ $request->manufacturer }}">
                        <input type="hidden" name="page" value="{{ $cur_page + 1 }}">

                        <button type="submit" class="btn btn-primary"> Page suivante </button>
                    </form>
                </div>
                <div class="row search-result">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead >
                                <tr>
                                    <th>Modèles</th>
                                    <th>Marque</th>
                                    <th>Catégorie</th>
                                    <th>Complément</th>
                                    <th>Ident</th>
                                    <th>Pièces Détachées</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['treffer'] as $r)
                                <tr>
                                    <!--td> <a href ="/{{ str_slug($r['geraeteart'], '-') }}/{{ $r['geraetennummer'] }}/{{ $r['geraeteid'] }}/{{ str_slug('pièces-detachees', '-') }}" >{{ $r['geraetennummer'] }}</a></td>
                                    <td>{{ $r['geraetename'] }}</td-->
                                    <td> <a href ="/{{ str_slug('pièces-detachees', '-') }}/<?php echo strtolower($r['geraetehersteller']); ?>/{{ str_slug($r['geraeteart'], '-') }}/{{ $r['geraetennummer'] }}/{{ $r['geraeteid'] }}/" >{{ $r['geraetennummer'] }}</a></td>
                                    
                                    <td class="bold">{{ $r['geraetehersteller'] }}</td>
                                    <td>{{ $r['geraeteart'] }}</td>
                                    <!--td> <a href ="/{{ str_slug($r['geraeteart'], '-') }}/{{ $r['geraetennummer'] }}/{{ $r['geraeteid'] }}/{{ str_slug('pièces-detachees', '-') }}" >Liste des Pièces Détachées</a> </td>
                                    <td></td-->
                                    <td>{{ $r['geraetename'] }}</td>    
                                    <td class="bold">{{ $r['geraeteidentnumber'] }}</td>
                                    <td> <a href ="/{{ str_slug('pièces-detachees', '-') }}/<?php echo strtolower($r['geraetehersteller']); ?>/{{ str_slug($r['geraeteart'], '-') }}/{{ $r['geraetennummer'] }}/{{ $r['geraeteid'] }}/" >Liste des Pièces Détachées</a> </td>
                                    <td></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @include('layouts.application.right_column')
            </div>
        </div>
    </div>

@endsection