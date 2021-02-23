<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TzUserTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('tz_user')->delete();

        \DB::table('tz_user')->insert([
            0 => [
                'id' => 11,
                'username' => '115fd8bb-d64e-47b2-89fa-21640927aeb2',
                'mobile' => '18616287252',
                'password' => '$2y$04$uQwafMS5WrsPB7xi0ishUe6HK0qUyhQTsmff0NcYZDaaFQChJigfa',
                'remember_token' => null,
                'created_at' => '2021-02-23 11:07:43',
                'updated_at' => '2021-02-23 11:07:43',
            ],
        ]);
    }
}
