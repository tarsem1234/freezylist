<?php

use Database\TruncateTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder.
 */
class DatabaseSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->truncateMultiple(['sessions']);

        $this->call(AccessTableSeeder::class);
        $this->call(HistoryTypeTableSeeder::class);
        $this->call(AdditionalInformationTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(IndustriesTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(SubRegionsTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(CountiesTableSeeder::class);
        $this->call(TypesTableSeeder::class);
        $this->call(ZipCodesTableSeeder::class);
        $this->call(NonUsCitiesTableSeeder::class);
        $this->call(SchoolDistrictsTableSeeder::class);
        $this->call(SchoolsTableSeeder::class);
        $this->call(MilitaryBasesTableSeeder::class);

        Model::reguard();
    }
}
