<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_user')->delete();

        \DB::table('admin_user')->insert([
            0 => [
                'id' => 1,
                'username' => 'admin',
                'password' => '$2y$10$7kMHGQV5jo0qsMEOpOW4M.AmqobLb3ouOU0yjc7i50vFf.tq8QqTi',
                'name' => 'Administrator',
                'avatar' => null,
                'remember_token' => 'vNi31McdRq3iGqTLYuNP9TXBRqfB5HDn3QsyU79lEIaBsbbyBAJOWmXZt8Jm',
                'created_at' => '2021-02-07 09:24:46',
                'updated_at' => '2021-02-07 09:24:46',
            ],
        ]);
    }
}
