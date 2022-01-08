<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminUserPermissionTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_user_permission')->delete();
    }
}
