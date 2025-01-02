<?php

use Illuminate\Database\Seeder;

class SubRegionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('sub_regions')->delete();

        \DB::table('sub_regions')->insert([
            0 => [
                'id' => 1,
                'region_id' => 5,
                'subregion' => 'Caribbean Islands',
            ],
            1 => [
                'id' => 2,
                'region_id' => 3,
                'subregion' => 'West & Central Asia',
            ],
            2 => [
                'id' => 3,
                'region_id' => 1,
                'subregion' => 'North Africa',
            ],
            3 => [
                'id' => 4,
                'region_id' => 4,
                'subregion' => 'Europe',
            ],
            4 => [
                'id' => 5,
                'region_id' => 1,
                'subregion' => 'Sub-Saharan Africa',
            ],
            5 => [
                'id' => 6,
                'region_id' => 6,
                'subregion' => 'Oceania',
            ],
            6 => [
                'id' => 7,
                'region_id' => 7,
                'subregion' => 'South America',
            ],
            7 => [
                'id' => 8,
                'region_id' => 2,
                'subregion' => 'Antarctic',
            ],
            8 => [
                'id' => 9,
                'region_id' => 3,
                'subregion' => 'South & South East Asia',
            ],
            9 => [
                'id' => 10,
                'region_id' => 5,
                'subregion' => 'Central America',
            ],
            10 => [
                'id' => 11,
                'region_id' => 4,
                'subregion' => 'North Asia',
            ],
            11 => [
                'id' => 12,
                'region_id' => 5,
                'subregion' => 'North America',
            ],
            12 => [
                'id' => 13,
                'region_id' => 3,
                'subregion' => 'East Asia',
            ],
            13 => [
                'id' => 14,
                'region_id' => 3,
                'subregion' => 'Oceania',
            ],
            14 => [
                'id' => 15,
                'region_id' => 5,
                'subregion' => 'Europe',
            ],
            15 => [
                'id' => 16,
                'region_id' => 4,
                'subregion' => 'West & Central Asia',
            ],
        ]);

    }
}
