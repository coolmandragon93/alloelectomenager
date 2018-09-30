<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'json',
    ];

    /**
     * Get the order that owns the history.
     */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function getOrders(){
        return $this->hasMany('App\Order');
    }
}
