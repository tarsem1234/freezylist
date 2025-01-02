<?php

use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('types')->delete();

        \DB::table('types')->insert([
            0 => [
                'id' => 1,
                'type' => 'MILITARY',
            ],
            1 => [
                'id' => 2,
                'type' => 'PO BOX',
            ],
            2 => [
                'id' => 3,
                'type' => 'STANDARD',
            ],
            3 => [
                'id' => 4,
                'type' => 'UNIQUE',
            ],
        ]);

    }
}
