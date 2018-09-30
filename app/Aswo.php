<?php

namespace App;

use Illuminate\Http\Request;

/**
 *
 */
class Aswo
{
    protected $eed_id;

    public function __construct(Request $request)
    {
        $this->eed_id = env('EED_ID');
    }

    public function call($params)
    {
        $url = "http://shop.euras.com/eed.php?format=json&sessionid=auto&id=".$this->eed_id."&".http_build_query($params);

        $json = file_get_contents($url);

        if ($json == false) {
            return [
                "error" => "No data"
            ];
        }

        $readjson=json_decode($json, true);

        if (is_array($readjson) == false) {
            return [
                "error" => true,
                "text" => $json
            ];
        }

        if ($readjson["fehlernummer"] !== "0") {
            return [
                "error" => $readjson["fehlernummer"],
                "text" => $readjson
            ];
        }

        return $readjson;
    }

    public function showError()
    {
        dd("Error");
    }

    public function article_details($id)
    {
        $params = [
            'art'   => 'artikeldetails', // Command
            'artnr' => $id // Id of the article
        ];

        return $this->call($params);
    }

    public function article_families($input)
    {
        $params = [
            'art'    => 'artikelgruppen',
            'vgruppe'=> $input['vgruppe']
            ];

        return $this->call($params);
    }

    public function article_search($input)
    {
        $params = [
            'art'    => 'artikelsuche', // Command
            'anzahl' => $input['anzahl'], // Results per page (max 50)
            'suchbg' => $input['suchbg'],
            'vgruppe' => $input['vgruppe']

        ];

        return $this->call($params);
    }

    public function appliance_search($input)
    {
        $page = isset($input['seite']) ? $input['seite'] : 1;
        $per_page = isset($input['anzahl']) ? $input['anzahl'] : 25;
        $hersteller = isset($input['hersteller']) ? $input['hersteller'] : '';

        $params = [
            'art'        => 'geraetesuche', // Command
            'hersteller' => $hersteller, // Manufacturer (optional)
            'anzahl'     => $per_page, // Results per page (max 25)
            'seite'      => $page, // Results per page (max 25)
            'suchbg'     => urlencode($input['suchbg'])
        ];

        if (isset($input['hersteller']) && ! empty($input['hersteller'])) {
            $params['hersteller'] = $input['hersteller'];
        }

        return $this->call($params);
    }

    public function article_detail_information($input)
    {
        $params = [
            'art'   => 'artikeldetails', // Command
            'artnr' => $input['artnr'], // Id of the article
            'sperrgut' => $input['sperrgut'],
            'attrib' => isset($input['attrib']) ? $input['attrib'] : 0,
        ];

        return $this->call($params);
    }

    public function articles_for_an_appliance($input)
    {
        $params = [
            'art'    => 'geraeteartikel', // Command
            'geraeteid' => $input['geraeteid'],
            'suchbg' => $input['suchbg'],
            'attrib' => $input['attrib'],
            'sperrgut' => $input['sperrgut'],
            'vgruppe' => $input['vgruppe'],
        ];

        return $this->call($params);
    }

    public function article_families_for_an_appliance($input)
    {
        $params = [
            'art'       => 'geraeteartikelgruppen', // Command
            'geraeteid' => $input['geraeteid']
        ];


        return $this->call($params);
    }

    public function articles_for_appliance_top($input)
    {
        $params = [
            'art'    => 'suggestliste', // Command
            'suchbg' => $input['suchbg'], // Id of the appliance
        ];

        return $this->call($params);
    }

    public function suggestlist($input)
    {
        $params = [
            'art'    => 'suggestliste', // Command
            'suchbg' => $input['suchbg'],
        ];

        return $this->call($params);
    }

    public function extended_article_search($input)
    {
        $params = [
            'art'    => 'artikelsuche_neu', // Command
            'suchbg' => $input['suchbg'],
        ];

        return $this->call($params);
    }

    public function search_result_quick_check($input)
    {
        $params = [
            'art'    => 'fundstellencheck', // Command
            'suchbg' => $input['suchbg'],
        ];

        return $this->call($params);
    }

    public function article_pictures_800($input)
    {
        $params = [
            'art'    => 'bild', // Command
            'artnr' => $input['artnr'],
        ];

        return $this->call($params);
    }

    public function article_pictures_200($input)
    {
        $eed_id = env('EED_ID');
        $cur_session_id = session_id();
        $artnr = $input['artnr'];
        $resize = $input['resize'];
        $url = 'https://shop.euras.com/thumb.php?eed=1&kdnr=' . $eed_id . '&sessionid=' . $cur_session_id . '&artnr=' . $artnr . '&resize=' . $resize;

        $response = array('tempurl'       => $url,
                          'neuesessionid' => '',
                          'fehlernummer'  => 0);

        return $response;
    }

    public function get_products_by_id($id, $f_id)
    {
        $params = [
            'art'    => 'geraeteartikel', // Command
            'geraeteid' => $id, // Id of the appliance
            'vgruppe' => $f_id // article family id choosen by the user or keyword "top" for just top articles
        ];

        return $this->call($params);
    }

    public function check_list_of_appliances_for_available_articles($input)
    {
        $params = [
            'art'    => 'geraetecheck', // Command
            'geraeteids' => $input['geraeteid'] // Id of the appliance
        ];

        return $this->call($params);
    }

    public function quick_search($input)
    {
        $params = [
            'art'    => 'fundstellencheck', // Command
            'suchbg' => $input['suchbg'] // Id of the appliance
        ];

        return $this->call($params);
    }

    public function appliance_finder($input)
    {
        $params = array_merge(['art' => 'geraetefinder'], $input);

        return $this->call($params);
    }
    
    /**
     * New appliance_details
     *
     * @param [type] $input
     * @return void
     */
    public function appliance_details($input)
    {
        $geraeteid = $input['geraeteid'];
        $params = [
            'art'        => 'geraetesuche', // Command
            'geraeteid' => $geraeteid // geraeteid (optional)
        ];

        return $this->call($params);
    }
}
