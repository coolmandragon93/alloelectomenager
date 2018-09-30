<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Aswo;
use Illuminate\Support\Facades\DB;

use Jenssegers\Date\Date;


class InfoController extends Controller
{
    /**
     * Home page
     *
     * @return Response
     */
    public function index()
    {
        $brands = DB::table('brands')->orderBy('name')->get();

        return view("info.index", compact('brands'));
    }
    /**
     * Home page
     * @return Response
     */
    public function conditions()
    {
        return view("info.conditions");
    }

    /**
     * Home page
     * @return Response
     */
    public function quisommesnous()
    {
        return view("info.quisommesnous");
    }

    /**
     * Home page
     * @return Response
     */
    public function paiement()
    {
        return view("info.paiement");
    }

    /**
     * Home page
     * @return Response
     */
    public function livraison()
    {
        return view("info.livraison");
    }

    /**
     * Brands page
     * @return Response
     */
    public function brands(Request $request,Aswo $aswo)
    {
        $brand = $request->brand;

        $metaData = ['title'=>'Pièces détachées '.$brand.' d\'origine - Electroménager','keywords'=>'pieces detachees electromenager,pieces electromenager, piece '.$brand,'description'=>'ll➤ Pièces détachées d’électroménager '.$brand.' d’origine ✱100% originales✱ ✅Lave-linge ✅Sèche-linge... ✅Paiement sécurisé ✅Livraison en 48h ✅Garantie 2 ans','robots'=>'INDEX,FOLLOW'];

        $brandProducts = [];

        $brand_detail = DB::table('brands')->where('name', $brand)->first();

        $is_brand_exists = count($brand_detail) > 0;
        if (!$is_brand_exists) {
            return redirect()->action("ProductsController@index");
        }

        $products = DB::table('products')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->whereRaw("LOWER(brands.name) = LOWER('$brand')")
            ->select('products.*')
            ->get();

        $limit = count($products) < 10 ? 5 : 10;
        $count = 0;
        foreach ($products as $value)
        {
            $product = $aswo->article_detail_information([
                'artnr'    => $value->aswo_id,
                'sperrgut' => 1,
            ]);

            if(! isset($product['ekpreis']) || $product['ekpreis'] == 0) {
                continue;
            } 

            if(isset($product['ekpreis'])){
                $product["price"] = get_price($product['ekpreis'], $product);
            }

            if(!isset($product['error'])){
                $product['img_url'] = $aswo->article_pictures_800(['artnr' => $value->aswo_id]);

                array_push($brandProducts,$product);
                $count++;
            }

            if ($count >= $limit)
                break;
        }

        return view("brands.index",compact('brand','brand_detail','metaData','brandProducts'));
    }    

    /**
     * Test page for example
     * @return text
     */
    public function yassine()
    {
        return "Hello Yassine";
    }
}

