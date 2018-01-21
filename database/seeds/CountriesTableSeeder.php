<?php

use Illuminate\Database\Seeder;
use App\Country;
use App\City;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Country::truncate();
        City::truncate();

//        factory(App\Country::class, 3)->create()->each(function ($country) {
//            $country->cities()->save(factory(App\City::class)->make());
//        });

        factory(App\Country::class, 3)->create()->each(function ($country) {
            $country->cities()->save(City::create([
                'name' => 'myCity',
                'country_id' => $country->id
            ]));
        });
    }
}
