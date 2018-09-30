<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sauver extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Product image path
     *
     * @var string
     */
    protected $img_path = "img/products/";

    /**
     * Get the brand that owns the product.
     */
    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    /**
     * Get the product img url
     */
     public function img_url()
     {
         return asset($this->img_path.$this->image);
     }

    /**
     * Get the product link
     */
     public function link()
     {
         return route('singleProduct', [str_slug($this->brand_name, '-'), $this->aswo_id]);
     }

    /**
     * Overide mpn if not set
     */
    public function getMpnAttribute($value)
    {
        if($value == '')
            return "AE".$this->aswo_id;

        return $value;
    }
}
