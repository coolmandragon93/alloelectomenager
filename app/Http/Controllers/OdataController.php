<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OdataController extends Controller
{
    public function odata()
   {
        $orders = json_decode((file_get_contents("https://alloelectromenager.com/jsondata"))); 
        return View('odata', compact("orders") );

    }
  


}
