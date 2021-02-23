<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminRolePermissionTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_role_permission')->delete();

        \DB::table('admin_role_permission')->insert([
            0 => [
                'role_id' => 1,
                'permission_id' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'role_id' => 1,
                'permission_id' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
