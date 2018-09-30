<?php

namespace App;

use Gloudemans\Shoppingcart\Facades\Cart;

/**
 *
 */
class Shipping
{
    /**
     * Get the carts shipping, if there is no shipping set yet, sets to 1
     *
     * @return $content
     */
    public static function shipping()
    {
        $content = Cart::content();

        if($content && count($content) > 0){
            $content = session()->has('shipping') ? session()->get('shipping') : session()->put('shipping',array('id'=>1,'total'=>'6.90'));
        }

        return $content;
    }

    /**
     * Sets the cart shipping
     * 
     */
    public static function setShipping($id)
    {
        if($id == 1 || $id == 2){
            $price = $id == 1 ? '6.90' : '10.90';

            if(session()->has('shipping')){
                session()->remove('shipping');
            }

            session()->put('shipping',array('id'=>$id,'total'=>$price));
        }

    }
}