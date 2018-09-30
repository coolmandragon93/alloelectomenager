<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Shipping;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{ 
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'invoice_at'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * Order states
     *
     * @var array
     */
    public static $states = [
        'pending_payment' => 'En attente de paiement',
        'pending' => 'Suspendue',
        'canceled' => "Annulée",
        'refunded' => 'Remboursée',
        'processing' => 'En cours',
        'done' => 'Terminée'
    ];

    /**
     * Get the order lines
     */
    public function lines()
    {
        return $this->hasMany('App\OrderLine');
    }

    /**
     * Get the order history
     */
    public function history()
    {
        return $this->hasMany('App\OrderHistory')->orderBy('created_at', 'desc');
    }

    /**
     * Get the Total Products attribute
     *
     * @param string $value
     *
     * @return string
     */
    public function getTotalProductsAttribute($value)
    {
        return $value / 100;
    }

    /**
     * Set the Total Products attribute
     *
     * @param string  $value
     *
     * @return void
     */
    public function setTotalProductsAttribute($value)
    {
        $this->attributes['total_products'] = $value * 100;
    }

    /**
     * Get the Total Shipping attribute
     *
     * @param string  $value
     *
     * @return string
     */
    public function getTotalShippingAttribute($value)
    {
        return $value / 100;
    }

    /**
     * Set the Total Shipping attribute
     *
     * @param string  $value
     *
     * @return void
     */
    public function setTotalShippingAttribute($value)
    {
        $this->attributes['total_shipping'] = $value * 100;
    }

    /**
     * Get the Total Paid attribute
     *
     * @param string  $value
     *
     * @return string
     */
    public function getTotalPaidAttribute($value)
    {
        return $value / 100;
    }

    /**
     * Set the Total Paid attribute
     *
     * @param string  $value
     *
     * @return void
     */
    public function setTotalPaidAttribute($value)
    {
        $this->attributes['total_paid'] = $value * 100;
    }

    /**
     * Store a newly created order
     *
     * @param array  $data
     *
     * @return void
     */
    public static function process($data)
    {
        $order = static::create([
            "cart_id" => 0,
            "payment_type" => $data['payment'],
            "total_products" => Cart::total(),
            "total_shipping" => Shipping::shipping()['total'],
            "tax_rate" => config('cart.tax'),
            "total_paid" => 0,
            "email" => $data['billing_email'],
            "shipping_first_name" => $data['shipping_first_name'],
            "shipping_last_name" => $data['shipping_last_name'],
            "shipping_phone" => $data['shipping_phone'],
            "shipping_company" => $data['shipping_company'],
            "shipping_address" => $data['shipping_address'],
            "shipping_zip" => $data['shipping_zip'],
            "shipping_city" => $data['shipping_city'],
            "shipping_country" => $data['shipping_country'],
            "billing_first_name" => $data['billing_first_name'],
            "billing_last_name" => $data['billing_last_name'],
            "billing_phone" => $data['billing_phone'],
            "billing_company" => $data['billing_company'],
            "billing_address" => $data['billing_address'],
            "billing_zip" => $data['billing_zip'],
            "billing_city" => $data['billing_city'],
            "billing_country" => $data['billing_country'],
            "shipp_delivred_date_o" => $data['shipp_delivred_date_o'],
            "shipp_delivred_date_t" => $data['shipp_delivred_date_t']

        ]);

        $order->pendingPayment();

        foreach (Cart::content() as $row) {
            OrderLine::create([
                "order_id" => $order->id,
                "product_id" => $row->id,
                "name" => $row->name,
                "price" => $row->price,
                "quantity" => $row->qty
            ]);
        }

        //dd("test");
        return $order;
    }

    public function setState($value, $data = null)
    {
        OrderHistory::create([
            "order_id" => $this->id,
            "state" => $value,
            "data" => $data
        ]);
    }

    public function state()
    {
        return $this->history()->orderBy('id','DESC')->first()->state;
    }

    public function pendingPayment($data = null) {
        $this->setState(static::$states['pending_payment'], $data);
    }

    public function canceled($data = null) {
        $this->setState(static::$states['canceled'], $data);
    }

    public function refunded($data = null) {
        $this->setState(static::$states['refunded'], $data);
    }

    public function processing($data = null) {
        $this->setState(static::$states['processing'], $data);
    }

    public function done($data = null) {
        $this->setState(static::$states['done'], $data);
    }
}
