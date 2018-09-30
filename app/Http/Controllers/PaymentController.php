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
use Illuminate\Support\Facades\Auth;

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

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class PaymentController extends Controller
{

    /**
     * Payment Index
     *
     * @return Response
     */
    public function index(Request $request, Aswo $aswo) {

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

        $cartContent = normalizeCart(Cart::content());

        $postData = $request->all();
        $mailData = array_merge($cart,$postData);

        $emailRoutes = ['emails.cc','emails.paypal','emails.bank','emails.check'];
        $viewRoutes = ['confirmation.cc','confirmation.paypal','confirmation.bank','confirmation.check'];
        $routeIndex = ($postData['payment'] - 1);

        $userData = $request->all();

        if($request->has('shippingAddress')) {
            $userData['shipping_first_name'] = $userData['billing_first_name'];
            $userData['shipping_last_name'] = $userData['billing_last_name'];
            $userData['shipping_company'] = $userData['billing_company'];
            $userData['shipping_phone'] = $userData['billing_phone'];
            $userData['shipping_address'] = $userData['billing_address'];
            $userData['shipping_city'] = $userData['billing_city'];
            $userData['shipping_zip'] = $userData['billing_zip'];
            $userData['shipping_country'] = $userData['billing_country'];
        }

        $order = Order::process($userData);
        $orderId = $order['original']['id'];

        $mailData['orderId'] = $orderId;
        $postData['orderId'] = $orderId;

        //create shopping cart record
        $this->insertCart($order,$cart);


        if($routeIndex != 0){
            Mail::send($emailRoutes[$routeIndex], $mailData, function ($message) use ($request) {
                $message->from('noreply@alloelectromenager.com', 'AlloElectromenager');
                $message->subject('Confirmation de votre commande');
                $message->to($request->input('billing_email'));
            });
        }

        //Send to admin email
        $admin_email = config('mail.admin_email');
        Mail::send($emailRoutes[$routeIndex], $mailData, function ($message) use ($admin_email) {
            $message->from('noreply@alloelectromenager.com', 'AlloElectromenager');
            $message->subject('Une nouvelle commande a été crée');
            $message->to($admin_email);
        });


        if($routeIndex == 1){
            $processPaypal = $this -> paypal($cart,$postData,$orderId);
        }else if($routeIndex == 0){
            return $this->atos($order);
        }else{
            return view($viewRoutes[$routeIndex], compact('postData','cart', 'cartContent'));
        }
    }

    public function paypalProcess(Request $request, Aswo $aswo) {

        \Log::info($request->all());

        $clientId = config('paypal.api_credential.paypal_client_id');
        $clientSecret = config('paypal.api_credential.paypal_secret');

        $apiContext = new \PayPal\Rest\ApiContext(new \PayPal\Auth\OAuthTokenCredential($clientId,$clientSecret));
        $apiContext->setConfig(config('paypal.config'));


        // Get payment object by passing paymentId
        $paymentId = $_GET['paymentId'];
        $payment = Payment::get($paymentId, $apiContext);
        $payerId = $_GET['PayerID'];

        // Execute payment with payer id
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {

            // Execute payment
            $result = $payment->execute($execution, $apiContext);

            $requestId = $_GET['orderId'];
            $id = isset($requestId) && is_numeric($requestId) ? (int) $requestId : null;

            $order = DB::table('orders')->where('id', '=',$id)->limit(1)->get();

            $order = $order[0];

            $query = DB::table('order_histories')->where('order_id', '=', $id)->limit(1)->get();
            $state = count($query) > 0 ? $query[0] : null;

            $cart = DB::table('shoppingcart')->where('orderid', '=', $id)->limit(1)->get();

            $cartContent = normalizeCart(Cart::content());

            $order -> status = $state -> state;

            // Update state
            DB::table('order_histories')->where('order_id', $id)->update(array('state' => 'En cours'));

            //Remove cart
            Cart::destroy();

            return view('confirmation.paypal', compact('order','cart', 'cartContent'));

        } catch (PayPal\Exception\PayPalConnectionException $ex) {

            print_r($ex);

        } catch (Exception $ex) {
            print_r($ex);

        }
    }

    public function atosProcess(Request $request){

        // Get data from Mercanet and decode
        $message="message=".$request->get('DATA');
        $pathfile="pathfile=".resource_path("atos/pathfile");
        $path_bin = resource_path("atos/response");

        $message = escapeshellcmd($message);
        $raw_result=exec("$path_bin $pathfile $message");
        $result = explode("!", $raw_result);

        $formatted_result = [
            "code" => $result[1],
            "error" => $result[2],
            "merchant_id" => $result[3],
            "merchant_country" => $result[4],
            "amount" => $result[5],
            "transaction_id" => $result[6],
            "payment_means" => $result[7],
            "transmission_date" => $result[8],
            "payment_time" => $result[9],
            "payment_date" => $result[10],
            "response_code" => $result[11],
            "payment_certificate" => $result[12],
            "authorisation_id" => $result[13],
            "currency_code" => $result[14],
            "card_number" => $result[15],
            "cvv_flag" => $result[16],
            "cvv_response_code" => $result[17],
            "bank_response_code" => $result[18],
            "complementary_code" => $result[19],
            "complementary_info" => $result[20],
            "return_context" => $result[21],
            "caddie" => $result[22],
            "receipt_complement" => $result[23],
            "merchant_language" => $result[24],
            "language" => $result[25],
            "customer_id" => $result[26],
            "order_id" => $result[27],
            "customer_email" => $result[28],
            "customer_ip_address" => $result[29],
            "capture_day" => $result[30],
            "capture_mode" => $result[31],
            "data" => $result[32],
            "order_validity" => $result[33],
            "transaction_condition" => $result[34],
            "statement_reference" => $result[35],
            "card_validity" => $result[36],
            "score_value" => $result[37],
            "score_color" => $result[38],
            "score_info" => $result[39],
            "score_threshold" => $result[40],
            "score_profile" => $result[41],
        ];

        //  Sortie de la fonction : !code!error!v1!v2!v3!...!v29
        //      - code=0    : la fonction retourne les données de la transaction dans les variables v1, v2, ...
        //              : Ces variables sont décrites dans le GUIDE DU PROGRAMMEUR
        //      - code=-1   : La fonction retourne un message d'erreur dans la variable error

        // Set up atos log
        $atos_log = new Logger('Atos Logs');
        $atos_log->pushHandler(new StreamHandler(storage_path("logs/atos-".date("Y-m-d").".log"), Logger::INFO));

        $atos_log->addInfo("Call received from atos");
        $atos_log->addInfo("Atos Results: ", $formatted_result);

        $requestId = $_GET['orderId'];
        $id = isset($requestId) && is_numeric($requestId) ? (int) $requestId : null;

        $order = DB::table('orders')->where('id', '=',$id)->limit(1)->get();

        $order = $order[0];

        $query = DB::table('order_histories')->where('order_id', '=', $id)->limit(1)->get();
        $state = count($query) > 0 ? $query[0] : null;

        $cart = DB::table('shoppingcart')->where('orderid', '=', $id)->limit(1)->get();

        $cartContent = normalizeCart(Cart::content());

        // Like we need another db call right?
        $eloquent_order = Order::findOrFail($request->get("orderId"));
        $eloquent_order->processing($formatted_result);

        $order->status = $state->state;
        $order = (Array) $order;

        Mail::send('emails.cc', $order, function ($message) use ($order) {
            $message->from('noreply@alloelectromenager.com', 'AlloElectromenager');
            $message->subject('Confirmation de votre commande');
            $message->to($order['email']);
        });

        $cart = (Array) $cart;
        // Update state
        // DB::table('order_histories')->where('order_id', $id)->update(array('state' => 'En cours'));

        Cart::destroy();
        return view('confirmation.cc', compact('order','cart', 'cartContent'));
    }

    public function atos($order){

        $total = $order['original']['total_products'] + $order['original']['total_shipping'];


        // For dev purpose only
        if(Auth::check() && Auth::user()->email === "me@alixg.com") {
            $total = 100;
        }

        $parm="merchant_id=005009405161783";
        $parm="$parm merchant_country=fr";
        $parm="$parm amount=".$total ;
        $parm="$parm currency_code=978";

        $parm="$parm pathfile=".resource_path("atos/pathfile");

        $parm.= " order_id=".$order['original']['id'];

        $return_url = route("cart.atosProcess", ["orderId" => $order['original']['id']]);

        $parm .= " normal_return_url=".$return_url;
        // $parm .= " cancel_return_url=".$return_url;
        $parm .= " automatic_response_url=".route("atos.log");

        if($order->total_products < 143) {
                $parm .=" data=NO_RESPONSE_PAGE;3D_BYPASS;";
            } else {
                $parm .=" data=NO_RESPONSE_PAGE";
            }

        $path_bin = resource_path("atos/request");

        \Log::info($parm);
        \Log::info($path_bin);

        $parm = escapeshellcmd($parm);
        $result = exec("$path_bin $parm");

        $tableau = explode("!", "$result");

        $code = $tableau[1];
        $error = $tableau[2];
        $message = $tableau[3];

        $error_message = false;

        if (( $code == "" ) && ( $error == "" ) )
        {
            \Log::error("ATOS: erreur appel request");
            \Log::error("ATOS: executable request non trouve $path_bin");
            $error_message = true;

        }
        else if ($code != 0){
            \Log::error("ATOS: Erreur appel API de paiement.");
            \Log::error("ATOS: message erreur : $error");
            $error_message = true;
        }

        return view('checkout.payment_atos', compact('order','message','error_message'));
    }

    public function insertCart($_order,$_cart){
        $cart = json_encode($_cart,true);

        DB::table('shoppingcart')->insert(
            [
                'orderid' => $_order['original']['id'],
                'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
                'items' => $cart
            ]
        );
    }

    public function paypal($cart,$postData,$orderId) {

        $clientId = config('paypal.api_credential.paypal_client_id');
        $clientSecret = config('paypal.api_credential.paypal_secret');

        $apiContext = new \PayPal\Rest\ApiContext(new \PayPal\Auth\OAuthTokenCredential($clientId,$clientSecret));
        $apiContext->setConfig(config('paypal.config'));



        // Create new payer and method
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // Set redirect urls
        $redirectUrls = new RedirectUrls();

        $redirectUrls   ->setReturnUrl('https://alloelectromenager.com/panier/confirmation/paypal?orderId='.$orderId)
            ->setCancelUrl('https://alloelectromenager.com/panier/cancel');


        $items = [];
        $subTotal = 0;

        if($cart){
            foreach($cart as $key => $value) {
                foreach($cart[$key] as $k => $b){
                    // Set item list
                    $item = new Item();
                    $item->setName($cart[$key][$k] -> name)
                        ->setCurrency('EUR')
                        ->setQuantity($cart[$key][$k] -> qty)
                        ->setPrice(my_format(httottc($cart[$key][$k] -> price)));
                    $subTotal += (my_format(httottc($cart[$key][$k] -> price)) * $cart[$key][$k] -> qty);
                    array_push($items,$item);
                }
            }
        }

        $itemList = new ItemList();
        $itemList->setItems($items);

        // Set payment details
        $shipping = Shipping::shipping()['total'];

        if(strtolower($postData['shipping_country']) != 'france'){
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
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }
    }

    public function atosLog(Request $request)
    {
        // Get data from Mercanet and decode
        $message="message=".$request->get('DATA');
        $pathfile="pathfile=".resource_path("atos/pathfile");
        $path_bin = resource_path("atos/response");

        $message = escapeshellcmd($message);
        $raw_result=exec("$path_bin $pathfile $message");
        $result = explode("!", $raw_result);

        $formatted_result = [
            "code" => $result[1],
            "error" => $result[2],
            "merchant_id" => $result[3],
            "merchant_country" => $result[4],
            "amount" => $result[5],
            "transaction_id" => $result[6],
            "payment_means" => $result[7],
            "transmission_date" => $result[8],
            "payment_time" => $result[9],
            "payment_date" => $result[10],
            "response_code" => $result[11],
            "payment_certificate" => $result[12],
            "authorisation_id" => $result[13],
            "currency_code" => $result[14],
            "card_number" => $result[15],
            "cvv_flag" => $result[16],
            "cvv_response_code" => $result[17],
            "bank_response_code" => $result[18],
            "complementary_code" => $result[19],
            "complementary_info" => $result[20],
            "return_context" => $result[21],
            "caddie" => $result[22],
            "receipt_complement" => $result[23],
            "merchant_language" => $result[24],
            "language" => $result[25],
            "customer_id" => $result[26],
            "order_id" => $result[27],
            "customer_email" => $result[28],
            "customer_ip_address" => $result[29],
            "capture_day" => $result[30],
            "capture_mode" => $result[31],
            "data" => $result[32],
            "order_validity" => $result[33],
            "transaction_condition" => $result[34],
            "statement_reference" => $result[35],
            "card_validity" => $result[36],
            "score_value" => $result[37],
            "score_color" => $result[38],
            "score_info" => $result[39],
            "score_threshold" => $result[40],
            "score_profile" => $result[41],
        ];

        \Log::info("Atos automatic notif");
        \Log::info($formatted_result);
    }
}
