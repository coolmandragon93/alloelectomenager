<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceRule extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the lower attribute
     *
     * @param  string  $value
     * @return string
     */
    public function getLowerAttribute($value)
    {
        return $value / 100;
    }

    /**
     * Set the lower attribute
     *
     * @param  string  $value
     * @return void
     */
    public function setLowerAttribute($value)
    {
        $this->attributes['lower'] = $value * 100;
    }

    /**
     * Get the lower attribute
     *
     * @param  string  $value
     * @return string
     */
    public function getUpperAttribute($value)
    {
        return $value / 100;
    }

    /**
     * Set the lower attribute
     *
     * @param  string  $value
     * @return void
     */
    public function setUpperAttribute($value)
    {
        $this->attributes['upper'] = $value * 100;
    }

    /**
     * Get the formatted price with the margin and the VTA
     *
     * @param  string  $price
     * @return void
     */
    public static function getPrice($price) {
        $result = my_format(static::getRawPrice($price));
        return $result;
    }

    /**
     * Get the formatted price with the margin without the VTA
     *
     * @param  string  $price
     * @return void
     */
    public static function getPriceWithoutVta($price) {
        $result = my_format(static::getRawPriceWithoutVta($price));
        return $result;
    }

    /**
     * Get the raw price with the margin with the VTA
     *
     * @param  string  $price
     * @return void
     */
    public static function getRawPrice($price) {
        $result = static::getRawPriceWithoutVta($price) * (1 + config("cart.tax")/100);
        return $result;
    }

    /**
     * Get the raw price with the margin without the VTA
     *
     * @param  string  $price
     * @return void
     */
    public static function getRawPriceWithoutVta($price) {
        // Clean up the price
        $clean_price = get_raw_price($price);
        // Since we store price as an integer and we search on the integer before it gets mutated
        $wherePrice = ($clean_price * 100);
        $model = static::where("lower", "<", $wherePrice)->where("upper", ">=", $wherePrice)->first();
        if($model)
        {
            // Margin
            $margin = 1 + ($model->margin/100);

            $result = $clean_price * $margin;

            return $result;
        }
        else{
            return 0;
        }
    }

    public static function removeVta($price) {
        return my_format($price * 0.8333);
    }
}
