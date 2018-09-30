<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the order that owns the line.
     */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    /**
     * Get the Price attribute
     *
     * @param string  $value
     *
     * @return string
     */
    public function getPriceAttribute($value)
    {
        return $value / 100;
    }

    /**
     * Set the Price attribute
     *
     * @param string  $value
     *
     * @return void
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100;
    }

    public function total() 
    {
        return $this->getPriceAttribute() * $this->price;
    }


    public function tax_price($value)
    {
        return round($value * 1.2, 1);
    }

    public function total_price()
    {
        return $this->tax_price($this->price) * $this->quantity;
    }
}
