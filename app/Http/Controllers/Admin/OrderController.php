<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Order;
use Mail;
use PDF;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('lines', 'history')->orderBy('created_at', 'desc')->paginate(100);

        return view("admin.orders.index", compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('lines', 'history')->findOrFail($id);

        return view("admin.orders.show", compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::with('lines', 'history')->findOrFail($id);
        $status = $request->get("status");

        // Update state
        $order->setState(Order::$states[$status], $request->get('data'));

        if($status == 'done'){
            // Update tracking
            $order->update(["tracking" => $request->input('data')]);

            $toprint[] = $order;
            $pdf = PDF::loadView('admin.orders.pdf-invoice',compact('toprint'));
            $pdfPath = 'assets/front/pdf/invoices/facture-'.$order->id.'.pdf';

            $pdf->save($pdfPath);

            $orderData = $order;
            $orderData -> pdfPath = $pdfPath;

            Mail::send('emails.shipped',(array) ["order" => $order], function ($message) use ($orderData) {
                $message->from('noreply@alloelectromenager.com', 'AlloElectromenager');
                $message->subject('Commande expédiée');
                $message->attach($orderData->pdfPath);
                $message->to($orderData->email);
            });

            if(file_exists($pdfPath)){
                unlink($pdfPath);
            }
        }

        if($request->has('tracking')) {
            $order->update(["tracking" => $request->input('tracking')]);
        }

        flash('Order updated', 'success');

        // Add notification
        return redirect()->route('admin.orders.show', $order->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::findOrFail($id)->delete();

        // We need notification when an order has been deleted.
        // https://laracasts.com/series/laravel-5-fundamentals/episodes/20
        // Maybe it could also be a good idea to enable soft deletion on orders
        // since it is sensitive data https://laravel.com/docs/5.3/eloquent#soft-deleting
        return redirect()->route('admin.orders.index');
    }

    public function sendInvoice($id) {

        DB::table('orders')->where('id',$id) ->update(['invoice_at' => DB::raw('CURRENT_TIMESTAMP')]);

        $order = Order::with('lines', 'history')->findOrFail($id);

        if($order->payment_type == 0 || $order->payment_type == 1){
            $toprint[] = $order;
            $pdf = PDF::loadView('admin.orders.pdf-invoice',compact('toprint'));
            $pdfPath = 'assets/front/pdf/invoices/facture-'.$order->id.'.pdf';

            $pdf->save($pdfPath);
        }

        $orderData = $order;

        if($order->payment_type == 0 || $order->payment_type == 1){
            $orderData -> pdfPath = $pdfPath;
        }

        Mail::send('emails.invoice',(array) ["order" => $order], function ($message) use ($orderData) {
            $message->from('noreply@alloelectromenager.com', 'AlloElectromenager');
            $message->subject('Demande de paiement');
            if($orderData->payment_type == 0 || $orderData->payment_type == 1){
                $message->attach($orderData->pdfPath);
            }
            $message->to($orderData->email);
        });

        if(isset($orderData -> pdfPath) && file_exists($orderData -> pdfPath)){
            unlink($orderData -> pdfPath);
        }

        // Return to order
        return redirect()->route('admin.orders.show', $id);
    }

    public function invoice($id) {

        $toprint[] = Order::with('lines', 'history')->findOrFail($id);
        return view("admin.orders.invoice", compact('toprint'));
    }

    //Edit order
    
    public function edit($id)
    {
        $order = Order::with('lines', 'history')->findOrFail($id);

        return view("admin.orders.edit", compact('order'));
    }

     public function editOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->update($request->all());

        flash('Order updated', 'success');

        return redirect()->route('admin.orders.edit', $order->id);
    }

    public function order_data()
    {
        $orders = Order::with('lines', 'history')->orderBy('created_at', 'desc')->paginate(100);

        return view("admin.orders.order_data", compact('orders'));
    }

    public function show_order()
    {
        $orders = Order::with('lines', 'history')->orderBy('created_at', 'desc')->paginate(10000);

        foreach ($orders as $o) {

            if ($o->state() == 'En cours') {

                $liste[$o['id']] = [
                'id' => $o['id'],
                'order_status' => $o->state(),
                "order_date"  => $o['created_at'],
                "order_total"  => $o['total_products'],
                "shipping_method_title"  => $o['total_shipping'],
                "email"  => $o['email'],
                "phone" => $o['shipping_phone'],
                "shipping_company" => $o['shipping_company'],
                "shipping_first_name" => $o['shipping_first_name'],
                "shipping_last_name" => $o['shipping_last_name'],
                "shipping_address_1" => $o['shipping_address'],
                "shipping_address_2" => "",
                "shipping_postcode" => $o['shipping_zip'],
                "shipping_city" => $o['shipping_city'],
                "shipping_country" => $o['shipping_country'],
                "shipping_country_code" => "FR",
                "billing_company" => $o['shipping_company'],
                "billing_first_name" => $o['billing_first_name'],
                "billing_last_name" => $o['billing_last_name'],
                "billing_address_1" => $o['billing_address'],
                "billing_address_2" => "",
                "billing_postcode" => $o['billing_zip'],
                "billing_city" => $o['billing_city'],
                "billing_country" => $o['billing_country'],
                "billing_country_code" => "FR"
            ];

            }

             

        }

        return $liste;
    }

}
