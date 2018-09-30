{{--<div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="nav-login-dialog">
	<h3 class="widget-title">Member Login</h3>
	<p>Welcome back, friend. Login to get started</p>
	<hr />
	<form>
		<div class="form-group">
			<label>Email or Username</label>
			<input class="form-control" type="text" />
		</div>
		<div class="form-group">
			<label>Password</label>
			<input class="form-control" type="text" />
		</div>
		<div class="checkbox">
			<label><input class="i-check" type="checkbox" />Remember Me</label>
		</div>
		<input class="btn btn-primary" type="submit" value="Sign In" />
	</form>
	<div class="gap gap-small"></div>
	<ul class="list-inline">
		<li><a href="#nav-account-dialog" class="popup-text">Not Member Yet</a>
		</li>
		<li><a href="#nav-pwd-dialog" class="popup-text">Forgot Password?</a>
		</li>
	</ul>
</div>
<div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="nav-account-dialog">
	<h3 class="widget-title">Create TheBox Account</h3>
	<p>Ready to get best offers? Let's get started!</p>
	<hr />
	<form>
		<div class="form-group">
			<label>Email</label>
			<input class="form-control" type="text" />
		</div>
		<div class="form-group">
			<label>Password</label>
			<input class="form-control" type="text" />
		</div>
		<div class="form-group">
			<label>Repeat Password</label>
			<input class="form-control" type="text" />
		</div>
		<div class="form-group">
			<label>Phone Number</label>
			<input class="form-control" type="text" />
		</div>
		<div class="checkbox">
			<label>
				<input class="i-check" type="checkbox" />Subscribe to the Newsletter</label>
		</div>
		<input class="btn btn-primary" type="submit" value="Create Account" />
	</form>
	<div class="gap gap-small"></div>
	<ul class="list-inline">
		<li><a href="#nav-login-dialog" class="popup-text">Already Member</a>
		</li>
	</ul>
</div>
<div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="nav-pwd-dialog">
	<h3 class="widget-title">Password Recovery</h3>
	<p>Enter Your Email and We Will Send the Instructions</p>
	<hr />
	<form>
		<div class="form-group">
			<label>Your Email</label>
			<input class="form-control" type="text" />
		</div>
		<input class="btn btn-primary" type="submit" value="Recover Password" />
	</form>
</div>--}}
<nav class="navbar navbar-default navbar-main-white navbar-pad-top navbar-first">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" href="{{ route("home") }}">
				<img src="/assets/front/img/logos/alloelectro.png" alt="AlloElectromenager" title="Image du logo" />
			</a>
		</div>
		<form method="get" action="{{ route('search_appliance') }}" class="navbar-form navbar-left navbar-main-search navbar-main-search-category" role="search">
			<div class="form-group">
				<i class="fa fa-search"></i>
				<input class="form-control" type="text" name="serial" placeholder="Entrez votre référence" />
			</div>
			<a class="fa fa-search navbar-main-search-submit" href="#"></a>
		</form>
		<ul class="nav navbar-nav navbar-right navbar-mob-item-left">
			<li>
				<a href="#"><span >Besoin d'aide ?</span> <i class="fa fa-phone"></i> 08 99 25 30 57</a>
			</li>
			<li class="dropdown">
				<a href="{{ route("cart.index") }}">
					<span>Panier</span><i class="fa fa-shopping-cart"></i> 
					@if(Cart::count() > 0)
					{{ Cart::count() }} Produit{{ Cart::count() > 1 ? "s" : "" }}
					@else
					Vide
					@endif
				</a>
				<ul class="dropdown-menu dropdown-menu-shipping-cart">
					@foreach(Cart::content() as $item)
					<li>
						<div class="dropdown-menu-shipping-cart-inner">
							<p class="dropdown-menu-shipping-cart-item"><img src="{{ $item->image }}" alt="Image du produit" /><strong>{{ $item->qty }} x</strong>  {{ $item->name }}</p>
							<p class="dropdown-menu-shipping-cart-price">{{ my_format($item->total) }} €</p>
						</div>
					</li>
					@endforeach
					<li>
						<p class="dropdown-menu-shipping-cart-total">Total: {{ my_format(Cart::total()) }} €</p>
						@if(Cart::count() > 0) 
							<a href="{{ route('cart.index') }}" class="dropdown-menu-shipping-cart-checkout btn btn-primary"> Panier </a>
							<a href="{{ route('cart.checkout') }}" class="btn btn-primary">Checkout</a>
						@else 
							<a class="btn btn-primary empty-cart">Votre panier est vide </a>
							@endif
					</li>
				</ul>
			</li>
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#main-nav-collapse" area_expanded="false"><span class="sr-only">Main Menu</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
				</button>
			</div>
		</ul>
	</div>
</nav>

<nav class="navbar-default navbar-main-blue yamm">
	<div class="container">
		<div class="collapse navbar-collapse navbar-collapse-no-pad" id="main-nav-collapse">
			<ul class="nav navbar-nav">
				<li>
					<a href="/">Accueil</a>
				</li>
				<li>
					<a href="/">Trouver ma pièce détachée</a>
				</li>
				<li>
					<a href="{{ route('quisommesnous') }}">Qui sommes nous ?</a>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="{{ route('livraison') }}">Livraison</a>
				</li>
				<li><a href="{{ route('paiement') }}">Paiement sécurisé</a>
				</li>
				<li><a href="{{ action('ProductsController@contact', ['ref' => 1]) }}">Nous Contacter</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
<div class="row" style="background-color: #f1f1f1; padding: 10px 0;">
	<div class="container">
		<div class="col-xs-4 text-center">
			<span> <i class="fa fa-star"></i> <b>Livraison Express </b> 24h/48h* <b></b></span>
		</div>
		<div class="col-xs-4 text-center">
			<span><i class="fa fa-heart-o"></i>  <b>20 000+</b> Clients Satisfait</span>
		</div>
		<div class="col-xs-4 text-center">
			<span><i class="fa fa-check"></i> <b>Satisfait </b> ou <b>Remboursé</b></span>
		</div>
	</div>
</div>