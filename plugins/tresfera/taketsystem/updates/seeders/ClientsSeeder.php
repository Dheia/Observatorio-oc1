<?php

namespace Tresfera\Taketsystem\Updates\Seeders;

use Seeder;
use DB;
use Faker\Factory;
use Tresfera\Taketsystem\Models\Client;

class ClientsSeeder extends Seeder
{
    public function run()
    {
        DB::table('tresfera_taketsystem_clients')->truncate();

        $faker = Factory::create();

        for ($i = 1; $i < 3; $i++) {

            // Create a new client
            $client = new Client();
            $client->name = $faker->sentence;
            $client->max_devices = rand(20, 100);
            $client->save();
        }
    }
}
