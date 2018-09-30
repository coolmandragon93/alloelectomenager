<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Order;

class AdminController extends Controller
{
	/**
	 * Home page
	 * @return Response
	 */
    public function index()
    {
        return redirect()->route('admin.orders.index');
    }

    /**
     * Home page
     * @return Response
     */
    public function orderStatus(Request $request)
    {
        //params
        $requestId = $requestId = $request->id;
        $id = isset($requestId) && is_numeric($requestId) ? (int) $requestId : null;

        if($id){
            $postData = $request->all();

            if(isset($postData['status'])){
                $query = DB::table('order_histories')->where('order_id',$id) ->update(['state' => $postData['status']]);

                if($postData['status'] == 'Terminée' && isset($postData['tracking'])){
                    $query = DB::table('orders')->where('id',$id) ->update(['tracking' => $postData['tracking']]);

                    $order = DB::table('orders')->where('id', '=',$id)->limit(1)->get();
                    $order = (array) $order[0];

                    Mail::send('emails.shipped', $order, function ($message) {
                        $message->from('noreply@alloelectromenager.com', 'AlloElectromenager');
                        $message->subject('Confirmation de votre commande');
                        $message->to($order['billing_email']);
                    });
                }
            }

            $order = DB::table('orders')->where('id', '=',$id)->limit(1)->get();
            
            if(count($order) > 0){
                $order = $order[0];

                $query = DB::table('order_histories')->where('order_id', '=', $id)->limit(1)->get();
                $state = count($query) > 0 ? $query[0] : null;

                $cart = DB::table('shoppingcart')->where('orderid', '=', $id)->limit(1)->get();
                
                $order -> status = $state -> state;

                return view("admin.order",compact('order','cart'));
            }else{
                return redirect()->route('admin.index');
            }
        }else{
            return redirect()->route('admin.index');
        }
    }

    public function order($id)
    {
    	$order = Order::with('lines', 'history')->findOrFail($id);

        return view("admin.order",compact('order','cart'));
    }

    public function deleted_order($id){
        Order::findOrFail($id)->delete();

    	return redirect()->route('admin.index');
    }

}
