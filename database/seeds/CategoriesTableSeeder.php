<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('categories')->delete();

        \DB::table('categories')->insert([
            0 => [
                'id' => 6,
                'category' => 'Buying a Home',
                'description' => '<p>Buying a home is an exciting time!&nbsp;<br />
<br />
Perhaps you just started in your career, got married, finally paid off those college loans, or are simply looking for an investment. Whatever the case, there are some important aspects you may want to consider.</p>',
                'status' => 1,
                'created_at' => '2018-09-07 12:44:23',
                'updated_at' => '2018-09-07 12:44:23',
                'deleted_at' => null,
            ],
            1 => [
                'id' => 7,
                'category' => 'Finances & Lending',
                'description' => '<p>Finances &amp; Lending Description</p>',
                'status' => 1,
                'created_at' => '2018-09-11 11:55:23',
                'updated_at' => '2018-09-11 11:55:23',
                'deleted_at' => null,
            ],
            2 => [
                'id' => 8,
                'category' => 'Selling a Home',
                'description' => '<p>The home buying and selling process are more than opposites by definition, the experience is often antonymous as well. While buying a home is generally an exciting endeavor, the selling process offers challenges.&nbsp;<br />
<br />
<strong>See how we mitigate these challenges for you in the sessions below!</strong></p>',
                'status' => 1,
                'created_at' => '2018-09-07 12:41:15',
                'updated_at' => '2018-09-07 12:41:15',
                'deleted_at' => null,
            ],
            3 => [
                'id' => 9,
                'category' => 'Optimizing Realtors',
                'description' => '<p>Optimizing Realtors Description</p>',
                'status' => 1,
                'created_at' => '2018-09-11 11:55:35',
                'updated_at' => '2018-09-11 11:55:35',
                'deleted_at' => null,
            ],
            4 => [
                'id' => 10,
                'category' => 'Vacation & Timeshares',
                'description' => '<p>Vacation &amp; Timeshares Description</p>',
                'status' => 1,
                'created_at' => '2018-09-19 11:26:48',
                'updated_at' => '2018-09-19 11:26:48',
                'deleted_at' => null,
            ],
            5 => [
                'id' => 11,
                'category' => 'Guide For Landlords',
                'description' => '<p>Guide For Landlords Description</p>',
                'status' => 1,
                'created_at' => '2018-09-13 00:53:44',
                'updated_at' => '2018-09-13 00:53:44',
                'deleted_at' => null,
            ],
            6 => [
                'id' => 12,
                'category' => 'Guide To Renting',
                'description' => '<p>Guide To Renting Description</p>',
                'status' => 1,
                'created_at' => '2018-09-11 11:55:44',
                'updated_at' => '2018-09-11 11:55:44',
                'deleted_at' => null,
            ],
            7 => [
                'id' => 13,
                'category' => 'Selling a Home',
                'description' => '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>',
                'status' => 1,
                'created_at' => '2018-09-20 16:20:26',
                'updated_at' => '2018-09-20 16:20:26',
                'deleted_at' => null,
            ],
        ]);

    }
}
