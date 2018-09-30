@extends('layouts.application.template')

@section('title', 'Pièces détaché pour '.$brand.' '.$model)

@section('content')
	<br>
	<div class="container">
		<div class="row">
			<div class="col-sm-3 left_column">
				<!--search_detailed-->
				<div class="search_detailed">

					<div class="info-product-side-content info-product-left-em">
						<h1 class="info-product-side-header">
							<span>Pièces détachées pour <span class="highlight_cat">{{ "$brand" }}</span></span>
						</h1>

						<div class="info-product-side-text _info_product_side_text">
							Besoin d'une <strong>pièce détachée </strong><strong>pour réparer votre {{ "$brand" }}</strong> ? 
							Avec plus de 100&nbsp;000 pièces detachées AlloElectromenager vous propose un large choix.
						</div>

					</div>
				</div>

				<!--bloc_side_v2_delivery-->
				<div class="bloc_side_v2 bloc_side_v2_delivery">
					<p class="title">Livraison Rapide</p>
					<p><span class="span1">sous</span> <span class="span2">48h</span></p>
				</div>
				<!--bloc_side_v2 bloc_side_v2_payment-->
				<div class="bloc_side_v2 bloc_side_v2_payment">
					<p class="title">Paiement sécurisé</p>
				</div>
				<!--Reviews-->
				<div class="reviews">

					<!-- TrustBox widget --> <div class="trustpilot-widget" data-locale="fr-FR" data-template-id="539ad60defb9600b94d7df2c" data-businessunit-id="514dbc3c000064000524c7e3" data-style-height="500px" data-style-width="100%" data-stars="5"> </div> <!-- End TrustBox widget -->
				</div>
			</div>
			<div class="col-sm-9 right_column_main">
				<!--search_eed_content-->
				<h3 class="title-result"> {{ "" }} <span> {{ $type = str_replace("-", " ", $type)}} {{"$brand $model" }}</span> <!--Choisissez votre catégorie--></h3>
				<p>1- Choisissez la catégorie de votre pièce détachées : {{ "$brand" }}</p>
				<div class="search_categories_content">
					<ul>
						@foreach($article_families as $family)
							<li><a href="{{ route("search-results-family", [str_slug($type, '-'), str_slug($model, '-'), str_slug($appliance_id, '-'), $family['vgruppenid'], str_slug($family['vgruppenname'], "-")]) }}" > {{ $family['vgruppenname'] }} </a> </li>
						@endforeach
					</ul>

				</div>
				<br><p>2- Selectionner votre pièce détachée {{ "$brand" }} dans la liste ci-dessous.</p>
				<div class="clearfix"></div>

				<!--Product list-->
				<div class="best_seller_PV_content">
					<ul class="product_list">

						@foreach($articles_appliance as $article)

						
<?php


				            $products = App\Sauver::updateOrCreate([
				            'name' => $article['artikelbezeichnung'],
				            'description' => '',
				            'condition' => '',
				            'availability' => '',
				            'google_product_category' => '',
				            'gtin' => '',
				            'mpn' => '',
				            'aswo_id' =>  $article['artikelnummer'],
				            'brand_id' => 0,
				            'brand_name' => $type = str_replace("-", " ", $type),
				            'image' => $article['img_url']['tempurl'],
				            'purchase_price' => $article['ekpreis'],
				            'price' => get_price($article['ekpreis']),
				            'category' => $article['vgruppenname'],
				            'google_shopping' => 0,
				        	]);

							
				            
				            

                ?>
							<?php if($article['ekpreis'] == 0) continue; ?>

							{{-- if artikelnummer exists then augment --}}

							<li class="call_external_system">
								<input type="hidden" name="product_id" class="product_id" value="{{ $article['artikelnummer'] }}">

								<span data-link="{{ get_product_url($type, $model, $article['artikelnummer'], $article['vgruppenname'], $article['vgruppenid']) }}" class="item_visual" >
									<img src="{{ $article['img_url']['tempurl'] }}" width="100" height="100" alt="{{ $article['artikelbezeichnung'] }}" onerror="imgError(this);">
								</span>
								<div class="descr_box">
									<h3 class="product_name">
										<a href=" {{ get_product_url($type, $model, $article['artikelnummer'], $article['vgruppenname'], $article['vgruppenid']) }}">{{ $article['artikelbezeichnung'] }}</a>
									</h3>
									<h4 class="description_item">réf. : {{$article['artikelnummer']}}</h4>
									<h5>Catégorie : {{$article['vgruppenname']}}</h5>

									<div class="clearfix"></div>
									<a href="{{ get_product_url($type, $model, $article['artikelnummer'], $article['vgruppenname'], $article['vgruppenid']) }}" class="more">+ d'informations</a>
								</div>
								<div class="actions_box">
									<div class="price_box">
									<span class="value">
										@if(isset($article["final_price"]))
											{{ $article["final_price"] }}
										@else
											{{ get_price($article['ekpreis']) }}
										@endif

										<span class="currency">€</span>
										<span class="price_ttc">TTC</span>
									</span>
									</div>
									<div class="loading-ajax>" >&nbsp;</div>
									<p class="info-delivery shipping-rule-pd-page-101458">Livré chez vous le :
										<br>
										<span class="shipping-rule-101458 delivery_date_text"></span>
									</p>
									@if(isset($article['final_price']))
									<a class="btn btn-success btn-lg" style="padding: 7px 3px;" type="button" href="{{ add_to_cart_url($article['artikelnummer'], $article['artikelbezeichnung'], 1, \App\PriceRule::removeVta($article['final_price'])) }}"> <i class="fa fa-cart-plus"></i> Ajouter au panier</a>
									@else
									<a class="btn btn-success btn-lg" style="padding: 7px 3px;" type="button" href="{{ add_to_cart_url($article['artikelnummer'], $article['artikelbezeichnung'], 1, \App\PriceRule::getRawPriceWithoutVta($article['ekpreis'])) }}"> <i class="fa fa-cart-plus"></i> Ajouter au panier</a>
									@endif
								</div>
								<div class="lineclearfix" >&nbsp;</div>
							</li>
						@endforeach
					</ul>
				</div>

			</div>
		</div>
	</div>
	<script>
        function imgError(image) {

            image.onerror = "";
            image.src = "/img/no_img_avaliable.jpg";
            return true;
        }

        $(document).ready(function(){
            $('.call_external_system').each(function(){
                var product_id = $(this).find('.product_id').val();
                var this_product = $(this);
                $.get('/get_delivery_date/' + product_id, function(data){
                    this_product.find('.delivery_date_text').html(data);
                });
            });
        });

	</script>
@endsection