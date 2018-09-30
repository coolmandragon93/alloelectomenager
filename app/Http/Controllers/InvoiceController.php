<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests;
use App\Aswo;
use App\Shipping;
use App\Order;
use Mail;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;

class InvoiceController extends Controller
{

    /**
     * Payment Index
     *
     * @return Response
     */
    public function invoice($id) {
        $order = Order::with('lines', 'history')->findOrFail($id);

        if($order->payment_type == 1){
            $this -> atos($order);
        }else if($order->payment_type == 2){
            $this -> paypal($order);
        }
    }

    public function paypal($order) {

        $clientId = config('paypal.api_credential.paypal_client_id');
        $clientSecret = config('paypal.api_credential.paypal_secret');

        $apiContext = new \PayPal\Rest\ApiContext(new \PayPal\Auth\OAuthTokenCredential($clientId,$clientSecret));
        $apiContext->setConfig(config('paypal.config'));

        // Create new payer and method
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // Set redirect urls
        $redirectUrls = new RedirectUrls();

        $redirectUrls   ->setReturnUrl('https://alloelectromenager.com/panier/confirmation/paypal?orderId='.$order['id'])
            ->setCancelUrl('https://alloelectromenager.com/panier/cancel');

        $items = [];
        $subTotal = 0;

        if(isset($order -> lines)){
            $products = $order -> lines;

            foreach($products as $key => $value) {
                // Set item list
                $item = new Item();
                $item->setName($products[$key] -> name)
                    ->setCurrency('EUR')
                    ->setQuantity($products[$key] -> quantity)
                    ->setPrice(my_format(httottc($products[$key] -> price)));
                array_push($items,$item);
            }
        }
    
        foreach($items as $key => $value) {
            $subTotal += $items[$key] -> price;
        }
       
        $itemList = new ItemList();
        $itemList->setItems($items);
     
        // Set payment details
        $shipping = $order['total_shipping'];

        if(strtolower($order['shipping_country']) != 'france'){
            $shipping = $shipping + 2;
        }
       
        $details = new Details();
        $details->setShipping($shipping)
            ->setSubtotal($subTotal);

        // Set payment amount
        $total = my_format($subTotal + $shipping);

        $amount = new Amount();
        $amount->setCurrency("EUR")
            ->setTotal($total)
            ->setDetails($details);

        // Set transaction object
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        // Create the full payment object
        $payment = new Payment();
        $payment->setIntent("order")

            #set Payment immediate
            ->setIntent("sale")

            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($apiContext);

            // Get PayPal redirect URL and redirect user
            $approvalUrl = $payment->getApprovalLink();
            header("Location: ".$approvalUrl);
            die();
            // REDIRECT USER TO $approvalUrl
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            \Log::info($ex->getCode());
            \Log::info($ex->getData());

            die($ex);
        } catch (Exception $ex) {
            \Log::info($ex->getMessage());
            die($ex);
        }
    }

    public function atos($order){

        print ("<HTML><HEAD><TITLE>MERCANET - Paiement Securise sur Internet</TITLE></HEAD>");
        print ("<BODY bgcolor=#ffffff>");
        print ("<Font color=#000000>");
        print ("<center><H1>MERCANET</H1></center><br><br>");

        $total = $order['original']['total_products'] + $order['original']['total_shipping'];

        $parm="merchant_id=005009405161783";
        $parm="$parm merchant_country=fr";
        $parm="$parm amount=".$total ;
        $parm="$parm currency_code=978";

        $parm="$parm pathfile=/var/www/alloelectromenager.com/www/resources/atos/pathfile";

        $parm.= " order_id=".$order['original']['id'];

        $parm .= " normal_return_url=https://alloelectromenager.com/panier/confirmation/cc?orderId=".$order['original']['id'];

        $path_bin = "/var/www/alloelectromenager.com/www/resources/atos/request";

        $parm = escapeshellcmd($parm);
        $result=exec("$path_bin $parm");

        $tableau = explode ("!", "$result");

        $code = $tableau[1];
        $error = $tableau[2];
        $message = $tableau[3];

        if (( $code == "" ) && ( $error == "" ) )
        {
            print ("<BR><CENTER>erreur appel request</CENTER><BR>");
            print ("executable request non trouve $path_bin");
        }

        //  Erreur, affiche le message d'erreur

        else if ($code != 0){
            print ("<center><b><h2>Erreur appel API de paiement.</h2></center></b>");
            print ("<br><br><br>");
            print (" message erreur : $error <br>");
        }

        //  OK, affiche le formulaire HTML
        else {
            print ("<br><br>");

            # OK, affichage du mode DEBUG si activé
            print (" $error <br>");

            print ("  $message <br>");
        }

        print ("</BODY></HTML>");

    }

}
