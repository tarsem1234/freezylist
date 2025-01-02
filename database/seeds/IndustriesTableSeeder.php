<?php

use Illuminate\Database\Seeder;

class IndustriesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('industries')->delete();

        \DB::table('industries')->insert([
            0 => [
                'id' => 1,
                'industry' => 'Title & Settlement (Closing)',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            1 => [
                'id' => 2,
                'industry' => 'Attorney',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            2 => [
                'id' => 3,
                'industry' => 'Consultants & Administrative- edited',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            3 => [
                'id' => 4,
                'industry' => 'Transaction Coordinator',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            4 => [
                'id' => 5,
                'industry' => 'Inspection',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            5 => [
                'id' => 6,
                'industry' => 'Surveyors',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            6 => [
                'id' => 7,
                'industry' => 'Engineering',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            7 => [
                'id' => 8,
                'industry' => 'Insurance',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            8 => [
                'id' => 9,
                'industry' => 'Warranty',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            9 => [
                'id' => 10,
                'industry' => 'Landscaping',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            10 => [
                'id' => 11,
                'industry' => 'Arborist (Tree Service)',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            11 => [
                'id' => 12,
                'industry' => 'Accounting & Tax',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            12 => [
                'id' => 13,
                'industry' => 'Marketing',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            13 => [
                'id' => 14,
                'industry' => 'Home Contractor',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            14 => [
                'id' => 15,
                'industry' => 'Property Management',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            15 => [
                'id' => 16,
                'industry' => 'Background/Credit Check',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            16 => [
                'id' => 17,
                'industry' => 'Appraiser',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            17 => [
                'id' => 18,
                'industry' => 'Mortgage and Lending',
                'created_at' => '2019-02-01 14:59:26',
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);

    }
}
