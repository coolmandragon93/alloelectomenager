<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PriceRuleSeeder::class);
        $this->call(BrandsSeader::class);
        $this->call(ProductsSeeder::class);
        $this->call(UserSeeder::class);

        DB::table('users')->insert([
            'name' => 'yassine',
            'email' => 'yassine@email.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
