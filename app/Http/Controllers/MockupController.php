<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Aswo;
use Mail;
use Illuminate\Support\Facades\DB;
use App\Product;

use Jenssegers\Date\Date;


class MockupController extends Controller
{
    /**
     * Home page
     *
     * @return Response
     */
    public function index()
    {
        $brands = DB::table('brands')->orderBy('name')->get();

        return view("mockups.index", compact('brands'));
    }
    
    /**
     * Process Contact
     * @return Response
     */
    public function process(Request $request)
    {
        $postData = $request->all();
        $response = ['success'=>true,'post'=>$postData];

        if(count($postData) > 0){
            $data = [];
            $html = "<p style=\"width:100%;margin:20px 0 0 0;float:left;\">Vous avez reçu une demande a partir du formulaire de contact<br /><br /><b>Email :</b> ".$postData['email']."<br /><b>Téléphone :</b> ".$postData['phone']."<br /><b>Reference :</b> ".$postData['reference']."<br /><b>Marque :</b> ".$postData['brand']."<br /><b>Type :</b> ".$postData['type']."<b><br />Message :</b> ".$postData['message']."<br /><br />Merci</p>" ;
            
            Mail::raw(null, function ($message) use($html) {
                $message->from('noreply@alloelectromenager.com', 'AlloElectromenager');
                $message->subject('Formulaire de contact');
                $message->setBody($html,'text/html');
                $message->to('contact@allotelecommande.com');
            });
        }

        print(json_encode($response));
    }

    /**
     * Display the product list and categories for a specific appliance
     * @return Response
     */
    public function appliance()
    {
        return view("mockups.appliance");
    }

    function get_delivery_date($num_date)
    {
        Date::setLocale('fr');

        $deliver_date = "No longer available";
        if ($num_date != 0) {
            $next_day_num = $num_date + 2;
            $tmp_deliver_date = strftime('%w', strtotime("+" . $next_day_num . " day"));

            $tmp_date_off_num = $next_day_num;
            $tmp_date_of_week = strftime('%w', strtotime("+" . $tmp_date_off_num . " day"));
            while ($tmp_date_of_week == 0 || // sun
                $tmp_date_of_week == 6)     // sat
            {
                $tmp_date_off_num++;
                $tmp_date_of_week = strftime('%w', strtotime("+" . $tmp_date_off_num . " day"));
            }

            $deliver_date = new Date("+" . $tmp_date_off_num . " day");
            $deliver_date = $deliver_date->format('l j F');
        }

        return $deliver_date;
    }

    /**
     * Product page
     * @return Response
     */
    public function product(Aswo $aswo, $type, $model, $product_id, $family_name, $family_id)
    {
        $product_detail = $aswo->article_detail_information([
            'artnr'    => $product_id,
            'sperrgut' => 1,
        ]);

        $img_url = $aswo->article_pictures_800(['artnr' => $product_id]);
        
        $delivery_date = $this->get_delivery_date($product_detail['lieferzeit_in_tagen']);
        //print_r($product_detail['ekpreis']);die;
        
        $product_detail["price"] = get_price($product_detail['ekpreis'], $product_detail);
        if($product_db = Product::where('aswo_id', $product_id)->first()) {
            $product_detail["price"] = $product_db->price;
            $product_detail['artikelbezeichnung'] = $product_db->name;
        }

        // prevent short serial ( < 3 characters)
        while (strlen($model) < 3)
            $model = $model . '-';

        $suggest_list = $aswo->appliance_search([
            'suchbg'     => substr($model, 0, 3),
            'hersteller' => $product_detail['artikelhersteller'],
            'seite'      => 1
        ]);

        $exactly_suggest = null;
        foreach ($suggest_list['treffer'] as $key => $value)
        {
            if ($value['geraetennummer'] == $model)
            {
                $exactly_suggest = $value;
                break;
            }
        }

        $productName = $product_detail['artikelbezeichnung'];
        $brandName = $product_detail['artikelhersteller'];
        $categoryName = isset($product_detail['vgruppenbaum'][0]) ? $product_detail['vgruppenbaum'][0]['vgruppenname'] : '';

        $metaData = ['title'=>$productName.'  - '.$brandName.' - Pièces détachées électroménager','description'=>$productName.' '.$brandName.' disponible sur Allo Electromenager - Spécialiste de pièces détachées électroménager d’origine et accessoires pour tous types d’appareils: machine à laver, lave-vaiselle, aspirateur…','keywords'=>''];
        
        return view("mockups.product", array(
            'product_detail'  => $product_detail,
            'delivery_date'   => $delivery_date,
            'img_url'         => isset($img_url['tempurl']) ? $img_url['tempurl'] : '',
            'suggest_list'    => $suggest_list,
            'exactly_suggest' => $exactly_suggest,
            'metaData'=>$metaData,
            'product_db' => $product_db
        ));
    }

    /**
     * Product page
     * @return Response
     */
    public function singleProduct(Aswo $aswo, $model, $product_id)
    {
        $product_detail = $aswo->article_detail_information([
            'artnr'    => $product_id,
            'sperrgut' => 1,
        ]);
        
        $img_url = $aswo->article_pictures_800(['artnr' => $product_id]);
        
        $delivery_date = $this->get_delivery_date($product_detail['lieferzeit_in_tagen']);

        $product_detail["price"] = get_price($product_detail['ekpreis'], $product_detail);
        if($product_db = Product::where('aswo_id', $product_id)->first()) {
            $product_detail["price"] = $product_db->price;
            $product_detail['artikelbezeichnung'] = $product_db->name;
        }

        //prevent short serial ( < 3 characters)
        while (strlen($model) < 3)
            $model = $model . '-';

        $suggest_list = $aswo->appliance_search([
            'suchbg'     => substr($model, 0, 3),
            'hersteller' => substr($product_detail['artikelhersteller'], 0, 4),
            'seite'      => 1
        ]);

        $exactly_suggest = null;
        foreach ($suggest_list['treffer'] as $key => $value)
        {
            if ($value['geraetennummer'] == $model)
            {
                $exactly_suggest = $value;
                break;
            }
        }
        
        $productName = $product_detail['artikelbezeichnung'];
        $brandName = $product_detail['artikelhersteller'];
        $categoryName = isset($product_detail['vgruppenbaum'][0]) ? $product_detail['vgruppenbaum'][0]['vgruppenname'] : '';

        $metaData = ['title'=>$productName.'  - '.$brandName.' - Pièces détachées électroménager','description'=>$productName.' '.$brandName.' disponible sur Allo Electromenager - Spécialiste de pièces détachées électroménager d’origine et accessoires pour tous types d’appareils: machine à laver, lave-vaiselle, aspirateur…','keywords'=>''];
       
        return view("mockups.product", array(
            'product_detail'  => $product_detail,
            'delivery_date'   => $delivery_date,
            'img_url'         => isset($img_url['tempurl']) ? $img_url['tempurl'] : '',
            'suggest_list'    => $suggest_list,
            'exactly_suggest' => $exactly_suggest,
            'metaData'=>$metaData,
            'product_db' => $product_db
        ));
    }

    public function results()
    {
        return view("mockups.results");
    }

    /**
     * Cart
     * @return Response
     */
    public function cart()
    {
        return view("mockups.cart");
    }

    /**
     * Checkout page
     * @return Response
     */
    public function checkout()
    {
        return view("mockups.cart");
    }

    /**
     * Contact page
     * @return Response
     */
    public function contact()
    {
        return view("mockups.contact");
    }

    /**
     * Search_result page
     * @return Response
     */
    function ajax_get_delivery_date(Aswo $aswo, $product_id)
    {
        $product_detail = $aswo->article_detail_information(['artnr' => $product_id, 'sperrgut' => 1]);
        $delivery_date = $this->get_delivery_date($product_detail['lieferzeit_in_tagen']);

        return $delivery_date;
        exit;
    }
}

