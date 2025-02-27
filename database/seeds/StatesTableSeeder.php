<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('states')->delete();

        \DB::table('states')->insert([
            0 => [
                'id' => 1,
                'postal' => 'AL',
                'state' => 'Alabama',
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'id' => 2,
                'postal' => 'AK',
                'state' => 'Alaska',
                'created_at' => null,
                'updated_at' => null,
            ],
            2 => [
                'id' => 3,
                'postal' => 'AZ',
                'state' => 'Arizona',
                'created_at' => null,
                'updated_at' => null,
            ],
            3 => [
                'id' => 4,
                'postal' => 'AR',
                'state' => 'Arkansas',
                'created_at' => null,
                'updated_at' => null,
            ],
            4 => [
                'id' => 5,
                'postal' => 'CA',
                'state' => 'California',
                'created_at' => null,
                'updated_at' => null,
            ],
            5 => [
                'id' => 6,
                'postal' => 'CO',
                'state' => 'Colorado',
                'created_at' => null,
                'updated_at' => null,
            ],
            6 => [
                'id' => 7,
                'postal' => 'CT',
                'state' => 'Connecticut',
                'created_at' => null,
                'updated_at' => null,
            ],
            7 => [
                'id' => 8,
                'postal' => 'DE',
                'state' => 'Delaware',
                'created_at' => null,
                'updated_at' => null,
            ],
            8 => [
                'id' => 9,
                'postal' => 'FL',
                'state' => 'Florida',
                'created_at' => null,
                'updated_at' => null,
            ],
            9 => [
                'id' => 10,
                'postal' => 'GA',
                'state' => 'Georgia',
                'created_at' => null,
                'updated_at' => null,
            ],
            10 => [
                'id' => 11,
                'postal' => 'HI',
                'state' => 'Hawaii',
                'created_at' => null,
                'updated_at' => null,
            ],
            11 => [
                'id' => 12,
                'postal' => 'ID',
                'state' => 'Idaho',
                'created_at' => null,
                'updated_at' => null,
            ],
            12 => [
                'id' => 13,
                'postal' => 'IL',
                'state' => 'Illinois',
                'created_at' => null,
                'updated_at' => null,
            ],
            13 => [
                'id' => 14,
                'postal' => 'IN',
                'state' => 'Indiana',
                'created_at' => null,
                'updated_at' => null,
            ],
            14 => [
                'id' => 15,
                'postal' => 'IA',
                'state' => 'Iowa',
                'created_at' => null,
                'updated_at' => null,
            ],
            15 => [
                'id' => 16,
                'postal' => 'KS',
                'state' => 'Kansas',
                'created_at' => null,
                'updated_at' => null,
            ],
            16 => [
                'id' => 17,
                'postal' => 'KY',
                'state' => 'Kentucky',
                'created_at' => null,
                'updated_at' => null,
            ],
            17 => [
                'id' => 18,
                'postal' => 'LA',
                'state' => 'Louisiana',
                'created_at' => null,
                'updated_at' => null,
            ],
            18 => [
                'id' => 19,
                'postal' => 'ME',
                'state' => 'Maine',
                'created_at' => null,
                'updated_at' => null,
            ],
            19 => [
                'id' => 20,
                'postal' => 'MD',
                'state' => 'Maryland',
                'created_at' => null,
                'updated_at' => null,
            ],
            20 => [
                'id' => 21,
                'postal' => 'MA',
                'state' => 'Massachusetts',
                'created_at' => null,
                'updated_at' => null,
            ],
            21 => [
                'id' => 22,
                'postal' => 'MI',
                'state' => 'Michigan',
                'created_at' => null,
                'updated_at' => null,
            ],
            22 => [
                'id' => 23,
                'postal' => 'MN',
                'state' => 'Minnesota',
                'created_at' => null,
                'updated_at' => null,
            ],
            23 => [
                'id' => 24,
                'postal' => 'MS',
                'state' => 'Mississippi',
                'created_at' => null,
                'updated_at' => null,
            ],
            24 => [
                'id' => 25,
                'postal' => 'MO',
                'state' => 'Missouri',
                'created_at' => null,
                'updated_at' => null,
            ],
            25 => [
                'id' => 26,
                'postal' => 'MT',
                'state' => 'Montana',
                'created_at' => null,
                'updated_at' => null,
            ],
            26 => [
                'id' => 27,
                'postal' => 'NE',
                'state' => 'Nebraska',
                'created_at' => null,
                'updated_at' => null,
            ],
            27 => [
                'id' => 28,
                'postal' => 'NV',
                'state' => 'Nevada',
                'created_at' => null,
                'updated_at' => null,
            ],
            28 => [
                'id' => 29,
                'postal' => 'NH',
                'state' => 'New Hampshire',
                'created_at' => null,
                'updated_at' => null,
            ],
            29 => [
                'id' => 30,
                'postal' => 'NJ',
                'state' => 'New Jersey',
                'created_at' => null,
                'updated_at' => null,
            ],
            30 => [
                'id' => 31,
                'postal' => 'NM',
                'state' => 'New Mexico',
                'created_at' => null,
                'updated_at' => null,
            ],
            31 => [
                'id' => 32,
                'postal' => 'NY',
                'state' => 'New York',
                'created_at' => null,
                'updated_at' => null,
            ],
            32 => [
                'id' => 33,
                'postal' => 'NC',
                'state' => 'North Carolina',
                'created_at' => null,
                'updated_at' => null,
            ],
            33 => [
                'id' => 34,
                'postal' => 'ND',
                'state' => 'North Dakota',
                'created_at' => null,
                'updated_at' => null,
            ],
            34 => [
                'id' => 35,
                'postal' => 'OH',
                'state' => 'Ohio',
                'created_at' => null,
                'updated_at' => null,
            ],
            35 => [
                'id' => 36,
                'postal' => 'OK',
                'state' => 'Oklahoma',
                'created_at' => null,
                'updated_at' => null,
            ],
            36 => [
                'id' => 37,
                'postal' => 'OR',
                'state' => 'Oregon',
                'created_at' => null,
                'updated_at' => null,
            ],
            37 => [
                'id' => 38,
                'postal' => 'PA',
                'state' => 'Pennsylvania',
                'created_at' => null,
                'updated_at' => null,
            ],
            38 => [
                'id' => 39,
                'postal' => 'RI',
                'state' => 'Rhode Island',
                'created_at' => null,
                'updated_at' => null,
            ],
            39 => [
                'id' => 40,
                'postal' => 'SC',
                'state' => 'South Carolina',
                'created_at' => null,
                'updated_at' => null,
            ],
            40 => [
                'id' => 41,
                'postal' => 'SD',
                'state' => 'South Dakota',
                'created_at' => null,
                'updated_at' => null,
            ],
            41 => [
                'id' => 42,
                'postal' => 'TN',
                'state' => 'Tennessee',
                'created_at' => null,
                'updated_at' => null,
            ],
            42 => [
                'id' => 43,
                'postal' => 'TX',
                'state' => 'Texas',
                'created_at' => null,
                'updated_at' => null,
            ],
            43 => [
                'id' => 44,
                'postal' => 'UT',
                'state' => 'Utah',
                'created_at' => null,
                'updated_at' => null,
            ],
            44 => [
                'id' => 45,
                'postal' => 'VT',
                'state' => 'Vermont',
                'created_at' => null,
                'updated_at' => null,
            ],
            45 => [
                'id' => 46,
                'postal' => 'VA',
                'state' => 'Virginia',
                'created_at' => null,
                'updated_at' => null,
            ],
            46 => [
                'id' => 47,
                'postal' => 'WA',
                'state' => 'Washington',
                'created_at' => null,
                'updated_at' => null,
            ],
            47 => [
                'id' => 48,
                'postal' => 'WV',
                'state' => 'West Virginia',
                'created_at' => null,
                'updated_at' => null,
            ],
            48 => [
                'id' => 49,
                'postal' => 'WI',
                'state' => 'Wisconsin',
                'created_at' => null,
                'updated_at' => null,
            ],
            49 => [
                'id' => 50,
                'postal' => 'WY',
                'state' => 'Wyoming',
                'created_at' => null,
                'updated_at' => null,
            ],
            50 => [
                'id' => 51,
                'postal' => 'DC',
                'state' => 'District of Columbia',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

    }
}
