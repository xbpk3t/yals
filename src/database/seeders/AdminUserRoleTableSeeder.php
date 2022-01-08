<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminUserRoleTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_user_role')->delete();

        \DB::table('admin_user_role')->insert([
            0 => [
                'role_id' => 1,
                'user_id' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'role_id' => 1,
                'user_id' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
