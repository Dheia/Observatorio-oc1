<?php

namespace Tresfera\Taketsystem\Updates\Seeders;

use Seeder;
use DB;
use Backend\Models\UserGroup;

class UserGroupsSeeder extends Seeder
{
    public function run()
    {
        if ($group = UserGroup::where('code', 'admins')->first()) {
            DB::table('backend_user_groups')->where('id', '<>', $group->id)->delete();

            // Change admin default
            $group->is_new_user_default = 0;
            $group->save();
        }

        // Clients
        $group = new UserGroup();
        $group->name = 'Clients';
        $group->code = 'clients';
        $group->description = 'Taketsystem clients default group';
        $group->is_new_user_default = 1;
        $group->save();
    }
}
