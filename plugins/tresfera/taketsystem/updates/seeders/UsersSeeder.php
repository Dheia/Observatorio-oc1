<?php

namespace Tresfera\Taketsystem\Updates\Seeders;

use Seeder;
use DB;
use Faker\Factory;
use Backend\Models\User;
use Tresfera\Taketsystem\Models\Client;
use Backend\Models\UserGroup;

class UsersSeeder extends Seeder
{
    public function run()
    {
        if ($admin = User::where('login', 'admin')->first()) {
            DB::table('backend_users')->where('id', '<>', $admin->id)->delete();
            DB::table('backend_users_groups')->where('user_id', '<>', $admin->id)->delete();
            DB::table('backend_user_preferences')->where('user_id', '<>', $admin->id)->delete();
            DB::table('backend_user_throttle')->where('user_id', '<>', $admin->id)->delete();
        }

        $faker = Factory::create();

        foreach (Client::all() as $client) {
            for ($i = 1; $i < 3; $i++) {

                // Create a new user
                $username = $faker->username;
                $user = new User([]);
                $user->client()->associate($client);
                $user->first_name            = $faker->firstName;
                $user->last_name             = $faker->lastName;
                $user->login                 = $username;
                $user->email                 = $faker->email;
                $user->password              = $username;
                $user->password_confirmation = $username;
                $user->is_activated = 1;
                $user->save();

                $user->groups()->attach(UserGroup::where('code', 'clients')->pluck('id'));
            }
        }
    }
}
