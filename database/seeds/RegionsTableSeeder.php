<?php

use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('regions')->delete();

        \DB::table('regions')->insert([
            0 => [
                'id' => 1,
                'region' => 'Africa',
            ],
            1 => [
                'id' => 2,
                'region' => 'Antarctica',
            ],
            2 => [
                'id' => 3,
                'region' => 'Asia',
            ],
            3 => [
                'id' => 4,
                'region' => 'Europe',
            ],
            4 => [
                'id' => 5,
                'region' => 'North America',
            ],
            5 => [
                'id' => 6,
                'region' => 'Oceania',
            ],
            6 => [
                'id' => 7,
                'region' => 'South America',
            ],
        ]);

    }
}
