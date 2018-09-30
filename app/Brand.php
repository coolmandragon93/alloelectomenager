<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
	/**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
	
    /**
     * Get the products for a specific brand
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
