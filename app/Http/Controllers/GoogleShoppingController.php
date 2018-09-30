<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class GoogleShoppingController extends Controller
{
    /**
     * Display google shopping feed
     *
     * @return xml
     */
    public function xml()
    {

        // Get google shopping products
    	$products = Product::where('google_shopping', true)->get();

        // Get main file
        $xml_test = "";

        $patterns = [
            '/{{aswo_id}}/',
            '/{{name}}/',
            '/{{link}}/',
            '/{{description}}/',
            '/{{image_link}}/',
            '/{{price}}/',
            '/{{google_product_category}}/',
            '/{{brand}}/',
            '/{{gtin}}/',
            '/{{mpn}}/'
        ];

        // Get item template
        foreach ($products as $product) {
            if($product->price == 0)
                continue;

            $replacements = [
                $product->aswo_id,
                ucwords(preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $product->name)),
                $product->link(),
                (! isset($product->description) || $product->description == '') ? '' : $product->description,
                $product->img_url(),
                $product->price,
                $product->google_product_category,
                preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $product->brand_name),
                $product->gtin,
                (! isset($product->gtin) || $product->gtin == '') ? $product->mpn : '',
            ];

            $xml_test .= preg_replace($patterns, $replacements, file_get_contents(resource_path('feeds/google_shopping_item.xml')));
        }


        header ("Content-Type:text/xml; charset=utf-8");

        echo preg_replace('/{{items}}/i', $xml_test, file_get_contents(resource_path('feeds/google_shopping.xml')));
        exit;
    }
}
