<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Order;
use Mail;
use PDF;

class OrdersController extends Controller
{
     public function ShowOrders()
    {
        $orders = DB::table('orders')
        
        ->join('order_histories', function($join)
            {
                $join->on('orders.id', '=', 'order_histories.order_id')
                ->where('order_histories.state', 'En cours');
            })

        ->join('order_lines', 'orders.id', '=', 'order_lines.order_id')
        ->orderBy('order_histories.order_id', 'desc')
        ->paginate(50);

      

       foreach ($orders as $key => $post) {
		    $data[$key] = [
		        'id' => $post->order_id,
		        	"order_status" => $post->state,
		        	"order_date" => $post->created_at,
		        	"order_total" => $post->total_products,
		        	"order_shipping" => $post->total_shipping,
		        	"email" => $post->email,
		        	"phone" => $post->shipping_phone,
		        	"shipping_company" => $post->shipping_company,
		        	"shipping_first_name" => $post->shipping_first_name,
		        	"shipping_last_name" => $post->shipping_last_name,
		        	"shipping_address_1" => $post->shipping_address,
		        	"shipping_postcode" => $post->shipping_zip,
		        	"shipping_city" => $post->shipping_city,
		        	"shipping_country" => $post->shipping_country,
		        	"billing_company" => $post->billing_company,
		        	"billing_first_name" => $post->billing_first_name,
		        	"billing_last_name" => $post->billing_last_name,
		        	"billing_address_1" => $post->billing_address,
		        	"billing_postcode" => $post->billing_zip,
		        	"billing_city" => $post->billing_city,
		        	"billing_country" => $post->billing_country,
		        	"items" => [
		        		        "product_id" => $post->product_id,
        						"name"  => $post->name,
        						"price" => $post->price,
        						"quantity" => $post->quantity,
        						"total" => $post->price,
		        		],
		    ];
		}


		

    	return $data;

    }

    public function show($id)
    {
        $post[] = Order::with('lines', 'history')->findOrFail($id);

		    
		

        return $post;
    }

   
}
