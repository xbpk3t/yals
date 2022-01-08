<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminRoleTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_role')->delete();

        \DB::table('admin_role')->insert([
            0 => [
                'id' => 1,
                'name' => 'Administrator',
                'slug' => 'administrator',
                'created_at' => '2021-02-07 09:24:47',
                'updated_at' => '2021-02-07 09:24:47',
            ],
        ]);
    }
}
