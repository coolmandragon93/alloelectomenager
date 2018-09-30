<?php

use Illuminate\Database\Seeder;

class PriceRuleSeeder extends Seeder
{
	private $rules = [
		["lower" => 0.00,"upper" => 0.25,"margin" => 500],
		["lower" => 0.26,"upper" => 0.50,"margin" => 400],
		["lower" => 0.51,"upper" => 1.00,"margin" => 300],
		["lower" => 1.01,"upper" => 2.00,"margin" => 200],
		["lower" => 2.01,"upper" => 3.50,"margin" => 100],
		["lower" => 3.51,"upper" => 5.00,"margin" => 90],
		["lower" => 5.01,"upper" => 10.00,"margin" => 80],
		["lower" => 10.01,"upper" => 20.00,"margin" => 70],
		["lower" => 20.01,"upper" => 30.00,"margin" => 61],
		["lower" => 30.01,"upper" => 40.00,"margin" => 55],
		["lower" => 40.01,"upper" => 50.00,"margin" => 52],
		["lower" => 50.01,"upper" => 60.00,"margin" => 47],
		["lower" => 60.01,"upper" => 70.00,"margin" => 45],
		["lower" => 70.01,"upper" => 80.00,"margin" => 43],
		["lower" => 80.01,"upper" => 90.00,"margin" => 41],
		["lower" => 90.01,"upper" => 100.00,"margin" => 38],
		["lower" => 100.01,"upper" => 150.00,"margin" => 35],
		["lower" => 150.01,"upper" => 200.00,"margin" => 31],
		["lower" => 200.01,"upper" => 500.00,"margin" => 24],
		["lower" => 500.01,"upper" => 1000.00,"margin" => 20],
		["lower" => 1000.01,"upper" => 10000.00,"margin" => 6]
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	foreach ($this->rules as $rule) {
    		\App\PriceRule::create($rule);
    	}
    }
}
