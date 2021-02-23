<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminMenuTableSeeder::class);
        $this->call(AdminPermissionTableSeeder::class);
        $this->call(AdminRoleTableSeeder::class);
        $this->call(AdminRoleMenuTableSeeder::class);
        $this->call(AdminRolePermissionTableSeeder::class);
        $this->call(AdminUserTableSeeder::class);
        $this->call(AdminUserPermissionTableSeeder::class);
        $this->call(AdminUserRoleTableSeeder::class);
        $this->call(TzUserTableSeeder::class);
    }
}
