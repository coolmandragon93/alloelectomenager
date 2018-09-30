<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Aswo;
use App\Product;

use Jenssegers\Date\Date;

class SearchController extends Controller
{
    /**
     * Home page
     * @return Response
     */
    public function search_appliance(Aswo $aswo, Request $request)
    {
        $page = isset($request->page) ? $request->page : 1;

        $serial = $request->serial;

        // remove special characters
        $serial = preg_replace("/[^A-Za-z0-9]/", '', $serial);

        // prevent short serial ( < 3 characters)
        while (strlen($serial) < 3) {
            $serial = $serial . '-';
        }

        $result = $aswo->appliance_search(['suchbg'     => $serial,
                                           'hersteller' => $request->manufacturer,
                                           'seite'      => $page
        ]);

        if (count($result['treffer']) >= 1) {
            # Si nombre d'appliance est supérieur à 1, afficher les résultats des appliances (liens vers la page de l'appliance)
            return view('search.appliance-results', compact('result', 'request'));
        } else {
            # Si nombre d'appliance est egal a 0, afficher une page d'aide / Contact
            return redirect('/contact');
        }
    }

    /**
     * Search results page
     * @return Response
     */
    public function search_results(Aswo $aswo, $type, $model, $appliance_id, $vgruppenid = '', $vgruppenname = '')
    {
        //$model
        // https://github.com/jenssegers/date
        Date::setLocale('fr');
      
        $article_families = $aswo->article_families_for_an_appliance(['geraeteid' => $appliance_id]);
        
        $articles_appliance = $aswo->articles_for_an_appliance(['geraeteid' => $appliance_id,
            'suchbg'    => '',
            'attrib'    => 1,
            'sperrgut'  => 1,
            'vgruppe'   => $vgruppenid ?: 'top'
        ]);
        
        for ($i = 1; $i < count($articles_appliance["treffer"]) + 1; $i++) {
            if ($product = Product::where('aswo_id', $articles_appliance["treffer"][$i]['artikelnummer'])->first()) {
                // Modify fields in $article_appliance
                $articles_appliance["treffer"][$i]["final_price"] = $product->price;
                $articles_appliance["treffer"][$i]["artikelbezeichnung"] = $product->name;
            }

            $articles_appliance["treffer"][$i]['img_url'] = $aswo->article_pictures_200(['artnr' => $articles_appliance["treffer"][$i]['artikelnummer'], 'resize' => 200]);
        }

        if (!isset($articles_appliance["treffer"]) or count($articles_appliance["treffer"]) == 0) {
            return redirect('/contact');
        }
        
        return view("search.appliance", array(
            'article_families'     => $article_families["treffer"],
            'articles_appliance'   => $articles_appliance["treffer"],
            'model'                => $model,
            'brand'                => isset($articles_appliance["treffer"][1]["artikelhersteller"]) ? isset($articles_appliance["treffer"][1]["artikelhersteller"]) : '',
            'type'                 => $type,
            'appliance_id'         => $appliance_id
        ));
    }

    /**
     * Search results page
     * @return Response
     */
    public function search_results2(Aswo $aswo, $brand, $type, $model, $appliance_id, $vgruppenid = '', $vgruppenname = '')
    {
        //$model
        // https://github.com/jenssegers/date
        Date::setLocale('fr');

        $article_families = $aswo->article_families_for_an_appliance(['geraeteid' => $appliance_id]);
        
        $articles_appliance = $aswo->articles_for_an_appliance(['geraeteid' => $appliance_id,
            'suchbg'    => '',
            'attrib'    => 1,
            'sperrgut'  => 1,
            'vgruppe'   => $vgruppenid ?: 'top'
        ]);
        
        for ($i = 1; $i < count($articles_appliance["treffer"]) + 1; $i++) {
            // if exists
            if ($product = Product::where('aswo_id', $articles_appliance["treffer"][$i]['artikelnummer'])->first()) {
                // Modify fields in $article_appliance
                $articles_appliance["treffer"][$i]["final_price"] = $product->price;
                $articles_appliance["treffer"][$i]["artikelbezeichnung"] = $product->name;
            }

            $articles_appliance["treffer"][$i]['img_url'] = $aswo->article_pictures_200(['artnr' => $articles_appliance["treffer"][$i]['artikelnummer'], 'resize' => 200]);
        }

        if (!isset($articles_appliance["treffer"]) or count($articles_appliance["treffer"]) == 0) {
            return redirect('/contact');
        }
        
        return view("search.appliance", array(
            'article_families'     => $article_families["treffer"],
            'articles_appliance'   => $articles_appliance["treffer"],
            'model'                => $model,
            'brand'                => isset($articles_appliance["treffer"][1]["artikelhersteller"]) ? isset($articles_appliance["treffer"][1]["artikelhersteller"]) : '',
            'type'                 => $type,
            'appliance_id'         => $appliance_id
        ));
    }

    /**
     * Return result from aswo suggest list based on term typed by user
     *
     * @param Request $request
     * @return void
     */
    public function sendRequestSearchToAswo(Request $request)
    {
        //https://shop.euras.com/eed.php?format=json&sessionid=auto&id=u8Md(cCX;1dsDF4&art=suggestliste&suchbg="+ request.term
        $url = "https://shop.euras.com/eed.php?format=json&sessionid=auto&id=u8Md(cCX;1dsDF4&art=suggestliste&suchbg=".rawUrlEncode($request->term);
        $json = file_get_contents($url);
        $readjson=json_decode($json, true);
        return $readjson;
    }
    /**
    * New search by geraetet reffer
    *
    * @param Aswo $aswo
    * @param [type] $appliance_id
    * @param string $vgruppenid
    * @param string $vgruppenname
    * @return void
    */
    public function search_autocomplete_appliance(Aswo $aswo, $appliance_id, $vgruppenid = '', $vgruppenname = '')
    {
        //$model
        // https://github.com/jenssegers/date
        Date::setLocale('fr');
        $appliance = $aswo->appliance_details(['geraeteid' => $appliance_id]);
        $appliance = array_slice($appliance['treffer'], 0, 1);
        //dd($appliance[0]['geraeteart']);
        $article_families = $aswo->article_families_for_an_appliance(['geraeteid' => $appliance_id]);
        //dd($article_families);
        $articles_appliance = $aswo->articles_for_an_appliance(['geraeteid' => $appliance_id,
            'suchbg'    => '',
            'attrib'    => 1,
            'sperrgut'  => 1,
            'vgruppe'   => $vgruppenid ?: 'top'
        ]);
        
        for ($i = 1; $i < count($articles_appliance["treffer"]) + 1; $i++) {
            if ($product = Product::where('aswo_id', $articles_appliance["treffer"][$i]['artikelnummer'])->first()) {
                // Modify fields in $article_appliance
                $articles_appliance["treffer"][$i]["final_price"] = $product->price;
                $articles_appliance["treffer"][$i]["artikelbezeichnung"] = $product->name;
            }

            $articles_appliance["treffer"][$i]['img_url'] = $aswo->article_pictures_200(['artnr' => $articles_appliance["treffer"][$i]['artikelnummer'], 'resize' => 200]);
        }

        if (!isset($articles_appliance["treffer"]) or count($articles_appliance["treffer"]) == 0) {
            return redirect('/contact');
        }
        
        return view("search.autocomplete.appliance", array(
            'article_families'     => $article_families["treffer"],
            'articles_appliance'   => $articles_appliance["treffer"],
            'model'                => $appliance[0]['geraetehersteller'],
            'brand'                => $appliance[0]['geraetehersteller'],
            'type'                 => $appliance[0]['geraeteart'],
            'appliance_id'         => $appliance_id
        ));
    }
}
