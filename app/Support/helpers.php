<?php

function add_to_cart_url($id, $name, $qty, $price) {
    return route("cart.add", ["id" => $id, "name" => $name, "qty" => $qty, "price" => str_replace(",", ".", $price)]);
}

function my_format($price) {
    return number_format(round($price, 2), 2, ".", "");
}

function httottc($price) {
    return $price * 1.2;
}

function get_raw_price($price) {
    return (float) str_replace(",", ".", $price);
}

function get_price($price, $info = false) {
	if($info) {
		//\Log::info($info);
	}
    return \App\PriceRule::getPrice($price);
}

function get_product_url($type, $model, $artikelnummer, $vgruppenname, $vgruppenid) {
	return route("product", [
		str_slug($type, '-'), 
		str_slug($model, '-'), 
		str_slug($artikelnummer, '-'), 
		str_slug($vgruppenname, '-'), 
		str_slug($vgruppenid, '-')
	]);
}

function get_color_status($status) {
	switch ($status) {
		case 'Terminée':
			return 'primary';
			break;
		case 'Annulée':
			return 'danger';
			break;
		case 'En attente de paiement':
			return 'warning';
			break;
		case 'En cours':
			return 'success';
			break;
		
		default:
			return 'default';
			break;
	}
}

function normalizeCart($content) {
	$items = [];

	foreach ($content as $row) {
		$items[] = [
			'name' => $row->name,
			'ref' => $row->ref,
			'price' => $row->price,
			'qty' => $row->qty,
			'total' => $row->total
		];
	}

	return $items;
}