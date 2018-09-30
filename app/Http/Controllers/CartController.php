<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests;
use App\Aswo;
use App\Shipping;
use Illuminate\Support\Facades\URL;

class CartController extends Controller
{
	
	/**
	* Cart Index
    *
	* @return Response
	*/
	public function index(Aswo $aswo) {
		$cart = (array) Cart::content();
		
		if($cart){

			foreach($cart as $key => $value) {
				foreach($cart[$key] as $k => $b){
					$product_detail = $aswo->article_detail_information(['artnr'=> $cart[$key][$k] -> id,'sperrgut' => 1,]);
					$img_url = $aswo->article_pictures_800(['artnr' => $cart[$key][$k] -> id]);
					
					
					$cart[$key][$k] -> image = isset($img_url['tempurl']) ? $img_url['tempurl'] : null;
					$cart[$key][$k] -> ref = $product_detail['artikelnummer'];
					$cart[$key][$k] -> deliveryInt = $product_detail['lieferzeit_in_tagen'];
				}
			}

		}

		$shipping = Shipping::shipping();
		
		//d		d($cart);
		return view("cart.index", compact('cart'));
	}
	
	
	/**
	* Add to cart
	*
	* @return Response
	*/
	public function add(Request $request) {
		Cart::add($request->all());
		
		return redirect()->route("cart.index");
	}
	
	/**
	* Add to cart
	*
	* @return Response
	*/
	public function cancel() {
		
		return view("cart.cancel");
	}
	
	/**
	* Remove from cart
	*
	* @return Response
	*/
	public function remove(Request $request) {

		try {
			Cart::remove($request->get("rowId"));
		} catch (\Gloudemans\Shoppingcart\Exceptions\InvalidRowIDException $e) {
			\Log::error("RowId doesn't exists:" . $request->get("rowId"));
			\Log::error(URL::previous());
			\Log::error($request);
		}

		$redirect = $request->get("redirect");

		if($redirect && $redirect == 2){
			return redirect()->route("cart.checkout");
		}
		
		return redirect()->route("cart.index");
	}

	/**
	* Update Shipping
	*
	* @return Response
	*/
	public function shipping(Request $request) {
		Shipping::setShipping($request->get("id"));

		$redirect = $request->get("redirect");

		if($redirect && $redirect == 2){
			return redirect()->route("cart.checkout");
		}
		
		return redirect()->route("cart.index");
	}
	
	/**
	* Update Shipping
	*
	* @return Response
	*/
	public function checkout(Aswo $aswo) {
		$cart = (array) Cart::content();
		
		if($cart){

			foreach($cart as $key => $value) {
				foreach($cart[$key] as $k => $b){
					$product_detail = $aswo->article_detail_information(['artnr'=> $cart[$key][$k] -> id,'sperrgut' => 1,]);
					$img_url = $aswo->article_pictures_800(['artnr' => $cart[$key][$k] -> id]);
					
					
					$cart[$key][$k] -> ref = $product_detail['artikelnummer'];
				}
			}

		}

		$shipping = Shipping::shipping();
		
		return view("checkout.index", compact('cart'));
	}
	
	/**
	* Update cart
	*
	* @return Response
	*/
	public function update(Request $request) {
		$rowId = $request->get("rowId");
		$qty = $request->get("qty");

		try {
			Cart::update($rowId,$qty);
		} catch (\Gloudemans\Shoppingcart\Exceptions\InvalidRowIDException $e) {
			\Log::error("RowId doesn't exists:" . $rowId);
			\Log::error(URL::previous());
			\Log::error($request);
		}

		$redirect = $request->get("redirect");

		if($redirect && $redirect == 2){
			return redirect()->route("cart.checkout");
		}

		return redirect()->route("cart.index");		
	}
}
