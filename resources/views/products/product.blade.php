@extends('layouts.application.template')

@section('title', 'Produit')

@section('content')

<?php 

$img_url = str_replace('http://','https://',$img_url);

    $ref = json_decode((file_get_contents("https://tv.allotelecommande.com/references"))); 
	$liste = DB::table('products')->pluck('aswo_id')->toArray(); 
?>
									

	<div class="container">
		<div class="breadcrumb-container">
			<ul class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
				@foreach(array_reverse($product_detail['vgruppenbaum']) as $key => $value)
				<li>
					<a href="#" > <span class="first_uppercase">{{ $value['vgruppenname'] }}</span></a>
					<span class="arrow_crumb"></span>
				</li>
				@endforeach
				<li>
					{{ $product_detail['artikelbezeichnung'] }}
					<span class="arrow_crumb"></span>
				</li>
			</ul>
		</div>
		
		<div class="product-detail row">
			<div class="col-sm-9 col-content">
				<!--product-basic-info-->
				<section class="product-basic-info row">
					<div class="col-sm-8 col-md-12">
						<div class="product-images">
							<div class="product-main-image">
								<div class="main-image-container">
									<div class="main-image-container-table">
										<div class="main-image-container-cell">
                                            <img id="main-product-image" alt src="{{ $img_url == '' ? '/img/no_img_avaliable.jpg' : $img_url}}" href="{{ $img_url }}">
                                        </div>
									</div>
								</div>

							</div>

						</div>
						<div class="product-description">
						<h1><span itemprop="name">{{ $product_detail['artikelbezeichnung'] }}  
							<?php  
								foreach ($ref  as $r) {
                                   	if(in_array($r->REF_ASWO, $liste)) continue; 
		                                    	if ($product_detail['artikelnummer'] == $r->REF_ASWO) {
		                                    		echo "RÉF : ".$r->REF_Origine;
		                            }
		                        }
                            ?>
                            	
                            </span> </h1>
							<p class="product-rating" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
								<span class="rating-md r45">4,5 sur 5</span>
								 <span class="rating-value" itemprop="ratingValue">4,5</span> sur <span itemprop="bestRating">5</span>
							</p>

							<div class="description">
								<p class="lead">
									{{ ucfirst(strtolower(isset($product_detail['vgruppenbaum']) ? $product_detail['vgruppenbaum'][0]['vgruppenname'] : '')) }}      <br />
                                    RÉF : {{ $product_detail['artikelnummer'] }}
                                    <br><br>
                                    @if ($product_detail['artikelnummer'] == 5867559)
                                     Ceci est un produit qui est commandé exprès sur demande, c'est avec plaisir que nous le(s) commanderons pour vous, sachez toutefois que le délai de livraison sera plus long et le retour/annulation de cet article ne sera pas accepté.
                                     @endif

                                </p>
								</div>


							</div>
							<div class="clearfix"></div>
						</div>
				</section>

			</div>
			<div class="col-sm-3 right_column">
				<div id="col-basket" class="col-basket"> 
					<div class="sticky-basket-holder">
						<div  id="all-basket" class="sticky-basket">
							<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="basket-related add-item">
								<div class="price-large discounted">
									<span itemprop="priceCurrency" content="EU"></span><span itemprop="price">
									@if(isset($product_detail['final_price']))
										{{ $product_detail['final_price'] }}
									@else
										{{ $product_detail['price'] }}
									@endif
										€
									</span>
									<span class="ttc"> TTC </span>
									<p>EN STOCK</p>
								</div>
								<div class="info-delivery">
				                    <p class="title">Livré chez vous le :</p>
				                    <div class="loading-ajax" style="display: none;">&nbsp;</div>
				                    <p class="shipping-rule-pd-page" style="">
				                    	<?php
if ($_SERVER['SERVER_NAME'] == "website.com") // On line
{
   $number_of_the_day= "%e"; // Number of the day without "0"
}
else 
{
   $number_of_the_day = "%#d";  // The same on Windows/Wampserver
} 

setlocale(LC_TIME, 'fr_FR.utf8','fra'); // I'm french !

// i use this fonction ucfirst('string') for "V" Maj. and "J" Maj.

$day = ucfirst(strftime('%A')); 



//  "Vendredi 1 Janvier 2016"  (->  without "0")
?>
				                        <span class="date date1532394 date135581" style="padding-left: 32px;"> {{ $delivery_date }} </span><br>
				                        <span class="date-info">(selon votre choix de transporteur)</span>
				                    </p>
				                </div>
							</div>
							<div class="add-to-cart">
								<div class="text-center row">
									@if(isset($product_detail['final_price']))
									<a class="btn btn-success btn-lg col-sm-10 col-sm-offset-1" href="{{ add_to_cart_url($product_detail['artikelnummer'], $product_detail['artikelbezeichnung'], 1, \App\PriceRule::removeVta($product_detail['final_price'])) }}"><i class="fa fa-cart-plus" aria-hidden="true"></i> Ajouter au panier</a>
									@else
									<a class="btn btn-success btn-lg col-sm-10 col-sm-offset-1" href="{{ add_to_cart_url($product_detail['artikelnummer'], $product_detail['artikelbezeichnung'], 1, \App\PriceRule::getRawPriceWithoutVta($product_detail['ekpreis'])) }}"><i class="fa fa-cart-plus" aria-hidden="true"></i> Ajouter au panier</a>
									@endif
								</div>
							</div>
							<div class="under_add">
				                <ul class="under_add_list">
				                 	<li class="under_add_listitem under_add_listitem1"><span><span class="sup">14</span>&nbsp;jours pour changer d’avis</span></li>
				                    <li class="under_add_listitem under_add_listitem4"><span><span class="sup">Service technique</span><br>à votre écoute</span></li>
				                </ul>
				            </div>
						</div>
					</div>
				</div>

			</div>
			<div class="clearfix"></div>
			<!--product-info-tab-->
			<div class="product-info-tab col-xs-12">

				<ul class="nav nav-pills hidden-xs">
					<li class="active">
						<a href="#1a" data-toggle="tab">Description</a>
					</li>
					<li>
						<a href="#2a" data-toggle="tab">Avis</a>
					</li>
				</ul>

				<div class="right-content col-sm-3">
					<!--Reviews-->
					<div class="reviews">

					<!-- TrustBox widget --> <div class="trustpilot-widget" data-locale="fr-FR" data-template-id="539ad60defb9600b94d7df2c" data-businessunit-id="514dbc3c000064000524c7e3" data-style-height="500px" data-style-width="100%" data-stars="5"> </div> <!-- End TrustBox widget -->
					</div>
                </div>

				<div class="tab-content clearfix">

					<div class="tab-pane  active" id="1a">
						<div class="tab-content-inside row">

                            <div class="longDescription col-sm-9">
                                <h2>Description du produit</h2>
                                <p class="productDescription">
									Cette pièce détachée <b>{{ $product_detail['artikelbezeichnung'] }} {{ $product_detail['artikelhersteller'] }}</b></b> s’adapte  sur plusieurs appareils.
									Cette pièces détachée <b>{{ $product_detail['artikelhersteller'] }}</b>
									est également compatible avec les modèles ci-dessous (liste non exhaustive) :
                                    <br>
									@if ($exactly_suggest != null)
                                    100% compatible avec le
                                    
                                    <a href ="/{{ str_slug($exactly_suggest['geraeteart'], '-') }}/{{ $exactly_suggest['geraetennummer'] }}/{{ $exactly_suggest['geraeteid'] }}/{{ str_slug('pièces-detachees', '-') }}" class="pv-name">
                                    <!--a href="{{ "/products/search_results/". $exactly_suggest['geraetennummer'] ."/". $exactly_suggest['geraeteid'] }}"
                                       class="pv-name"-->
                                        <span class="manufacturer">{{ $exactly_suggest['geraetehersteller'] }}</span>
                                        <span class="spare-final_product_list-final_product_name"> {{ $exactly_suggest['geraetennummer'] }} </span>
                                    </a>
                                    et les modèles
                                    suivants :
									@endif
                                </p>
                                <div class="ref-app-productpage" id="search-pv-from-pd">

                                    <div class="search-bar-app">
                                        <input placeholder="Référence de votre appareil, expl : LG 58552" class="search-pv" id="search-pv" name="search-pv" value="">
                                    </div>
                                    <div class="container-list-app">
                                        <ul class="compatibility-tab-pv-list">
                                        	@if(count($suggest_list['treffer']) > 0)
                                            @foreach($suggest_list['treffer'] as $key => $value)
                                                <li>
                                                	<a href ="/{{ str_slug($value['geraeteart'], '-') }}/{{ $value['geraetennummer'] }}/{{ $value['geraeteid'] }}/{{ str_slug('pièces-detachees', '-') }}" class="pv-name">
                                                    <!--a href="{{ "/products/search_results/". $value['geraetennummer'] ."/".$value['geraeteid'] }}"
                                                       class="pv-name"-->
                                                        <span class="spare__final_product_list__final_product_type_name">{{ $value['geraeteart'] }}</span>
                                                        <span class="manufacturer">{{ $value['geraetehersteller'] }}</span>
                                                        <span class="spare__final_product_list__final_product_name"> {{ $value['geraetennummer'] }} </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                            @endif
                                        </ul>
                                        <div class="no-pv-found" style="display: none;">
                                            <p class="no-results">Nous n'avons aucun résultat correspondant à votre
                                                recherche.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="brands-links" style="display: block;">
                                    Marques compatibles : <a href="{{url( "/recherche?serial=&manufacturer=" . $product_detail['artikelhersteller']) }}"> {{ $product_detail['artikelhersteller'] }}</a></div>
                                <br>
                                Besoin d’un conseil concernant la catégorie.
								<a href="{{ url("contact") }}" >
                                {{ ucfirst(strtolower(isset($product_detail['vgruppenbaum']) ? $product_detail['vgruppenbaum'][0]['vgruppenname'] : '')) }}

                                {{ isset($product_detail['vgruppenbaum']) && isset($product_detail['vgruppenbaum'][1]) ? 'de ' . ucfirst(strtolower($product_detail['vgruppenbaum'][1]['vgruppenname'])) : '' }}
								</a>
                                , n’hésitez pas à nous contacter !
                            </div>

                      
                        </div>
                    </div>

                    <div class="tab-pane " id="2a">
                    	<div class="tab-content-inside row">

                            <div class="longDescription col-sm-9">
                            	<p class="product-rating" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
									<span class="rating-md r45">4,5 sur 5</span>
									 <span class="rating-value" itemprop="ratingValue">4,5</span> sur <span itemprop="bestRating">5</span>
								</p>
                            </div>
                    		
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<script type="text/javascript">
		
        $(document).ready(function() {
            
            $('.product-basic-info .slick-slide').click(function(e){
            	e.preventDefault();
            	
            	$('.product-basic-info .main-image-container-cell img').attr('src',$(this).find('a').attr("href"));
            });
            $('.product-images-carousel-modal .slick-slide').click(function(e){
            	e.preventDefault();
            	
            	$('.product-main-image-modal img').attr('src',$(this).find('a').attr("href"));
            });
            
        });
    
	</script>
@endsection