<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateBrandData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function updateBrand($data)
    {
        foreach ($data as $value)
        {
            DB::table('brands')
                ->where('name', '=', $value['name'])
                ->update($value['update']);
        }
    }

    public function up()
    {
        $data = [
            [
                'name' => 'Beko',
                'update' => [
                    'model_id' => 'DCU 7230W',
                    'number_of_image' => '1',
                    'is_dot' => '0',
                    'number_of_arrow_dot' => '2'
                ]
            ],
            [
                'name' => 'Brandt',
                'update' => [
                    'model_id' => 'CVP2600',
                    'number_of_image' => '2',
                    'is_dot' => '0',
                    'number_of_arrow_dot' => '1'
                ]
            ],
            [
                'name' => 'Hotpoint',
                'update' => [
                    'model_id' => 'SBL 2033 V/HA',
                    'number_of_image' => '1',
                    'is_dot' => '0',
                    'number_of_arrow_dot' => '1'
                ]
            ],
            [
                'name' => 'Indesit',
                'update' => [
                    'model_id' => 'TAA12 FR',
                    'number_of_image' => '3',
                    'is_dot' => '0',
                    'number_of_arrow_dot' => '2'
                ]
            ],
            [
                'name' => 'LG',
                'update' => [
                    'model_id' => 'VC5402CL',
                    'number_of_image' => '1',
                    'is_dot' => '0',
                    'number_of_arrow_dot' => '1'
                ]
            ],
            [
                'name' => 'Liebherr',
                'update' => [
                    'model_id' => 'ICBN 3366 index 20C/001',
                    'number_of_image' => '1',
                    'is_dot' => '1',
                    'number_of_arrow_dot' => '2'
                ]
            ],
            [
                'name' => 'Miele',
                'update' => [
                    'model_id' => 'S4222',
                    'number_of_image' => '2',
                    'is_dot' => '1',
                    'number_of_arrow_dot' => '1'
                ]
            ],
            [
                'name' => 'Moulinex',
                'update' => [
                    'model_id' => 'MO5335PA/4Q0',
                    'number_of_image' => '2',
                    'is_dot' => '0',
                    'number_of_arrow_dot' => '1'
                ]
            ],
            [
                'name' => 'Samsung',
                'update' => [
                    'model_id' => 'LE27T51BX/XEC',
                    'number_of_image' => '3',
                    'is_dot' => '0',
                    'number_of_arrow_dot' => '1'
                ]
            ],
            [
                'name' => 'Seb',
                'update' => [
                    'model_id' => 'FF162100/89A',
                    'number_of_image' => '1',
                    'is_dot' => '0',
                    'number_of_arrow_dot' => '1'
                ]
            ],
            [
                'name' => 'Smeg',
                'update' => [
                    'model_id' => 'LVD613X',
                    'number_of_image' => '1',
                    'is_dot' => '0',
                    'number_of_arrow_dot' => '1'
                ]
            ],
            [
                'name' => 'Whirlpool',
                'update' => [
                    'model_id' => 'ARC140',
                    'number_of_image' => '2',
                    'is_dot' => '1',
                    'number_of_arrow_dot' => '2'
                ]
            ],
        ];

        $this->updateBrand($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
