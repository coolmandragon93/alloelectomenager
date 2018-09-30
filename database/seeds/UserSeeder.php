<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Yassine adil',
            'email' => 'adil.yassine@orange.fr',
            'password' => bcrypt('123456'),
        ]);
    }
}

?>