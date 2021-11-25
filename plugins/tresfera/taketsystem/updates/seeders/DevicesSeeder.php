<?php

namespace Tresfera\Taketsystem\Updates\Seeders;

use Seeder;
use DB;
use Faker\Factory;
use Faker\Provider\Internet;
use Tresfera\Taketsystem\Models\Client;
use Tresfera\Taketsystem\Models\Shop;
use Tresfera\Taketsystem\Models\Device;

class DevicesSeeder extends Seeder
{
    public function run()
    {
        DB::table('tresfera_taketsystem_devices')->truncate();

        $faker = Factory::create();
        $faker->addProvider(new Internet($faker));

        foreach (Shop::all() as $shop) {
            for ($i = 1; $i <= 10; $i++) {

                // Create a new device
                $device = new Device();
                $device->client()->associate($shop->client);
                $device->shop()->associate($shop);
                $device->city()->associate($shop->city);
                $device->region()->associate($shop->city->region);
                $device->mac = $faker->unique()->macAddress;
                $device->save();
            }
        }
    }
}
