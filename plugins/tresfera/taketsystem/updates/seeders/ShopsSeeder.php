<?php

namespace Tresfera\Taketsystem\Updates\Seeders;

use Seeder;
use DB;
use Faker\Factory;
use Faker\Provider\es_ES\Address;
use Tresfera\Taketsystem\Models\Client;
use Tresfera\Taketsystem\Models\Shop;
use Tresfera\Taketsystem\Models\City;

class ShopsSeeder extends Seeder
{
    public function run()
    {
        DB::table('tresfera_taketsystem_shops')->truncate();

        $faker = Factory::create();
        $faker->addProvider(new Address($faker));

        for ($i = 1; $i <= 10; $i++) {

            // Create a new shop
            $shop = new Shop();
            $shop->client()->associate(Client::orderBy(DB::raw('RAND()'))->first());
            $shop->city()->associate(City::orderBy(DB::raw('RAND()'))->first());
            $shop->name = $faker->sentence;
            $shop->postcode = $faker->postcode;
            $shop->address = $faker->address;
            $shop->save();
        }
        
		// Special devel test device  
        $shop->secret = 'FHTVXY';
		$shop->save();
    }
}
