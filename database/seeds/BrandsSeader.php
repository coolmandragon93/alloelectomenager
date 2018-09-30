<?php

use Illuminate\Database\Seeder;

class BrandsSeader extends Seeder
{
    private $brands = [
        ['name' => 'Aeg'],
        ['name' => 'Arcelik'],
        ['name' => 'Ariston'],
        ['name' => 'Babyliss'],
        ['name' => 'Beko'],
        ['name' => 'Bitron'],
        ['name' => 'Brandt'],
        ['name' => 'Braun'],
        ['name' => 'Bosch'],
        ['name' => 'Calor'],
        ['name' => 'Candy'],
        ['name' => 'De Dietrich'],
        ['name' => 'Delonghi'],
        ['name' => 'Domena'],
        ['name' => 'Dometic'],
        ['name' => 'Dyson'],
        ['name' => 'Eio'],
        ['name' => 'Electrolux'],
        ['name' => 'Fagor'],
        ['name' => 'Far'],
        ['name' => 'Faure'],
        ['name' => 'Gorenje'],
        ['name' => 'Hoover'],
        ['name' => 'Hotpoint'],
        ['name' => 'Indesit'],
        ['name' => 'Karcher'],
        ['name' => 'Kenwood'],
        ['name' => 'Krups'],
        ['name' => 'Lagrange'],
        ['name' => 'LG'],
        ['name' => 'Liebherr'],
        ['name' => 'Miele'],
        ['name' => 'Magimix'],
        ['name' => 'Moulinex'],
        ['name' => 'Neff'],
        ['name' => 'Nilfisk'],
        ['name' => 'Philips'],
        ['name' => 'Proline'],
        ['name' => 'Ranco'],
        ['name' => 'Riviera'],
        ['name' => 'Rosieres'],
        ['name' => 'Rowenta'],
        ['name' => 'Saeco'],
        ['name' => 'Samsung'],
        ['name' => 'Seb'],
        ['name' => 'Scholtes'],
        ['name' => 'Sharp'],
        ['name' => 'Siemens'],
        ['name' => 'Sidex'],
        ['name' => 'Smeg'],
        ['name' => 'Tefal'],
        ['name' => 'Thermor'],
        ['name' => 'Thomson'],
        ['name' => 'Vedette'],
        ['name' => 'Whirlpool'],
        ['name' => 'Zanussi']
        ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->brands as $brand) {
            DB::table('brands')->insert([
                'name' => $brand['name']
            ]);
        }
    }
}
