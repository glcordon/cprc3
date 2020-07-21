<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$74542GqzhP.iV3U/1f7Q5eFJZnmTSCuR8D7lYkk77X9KQ7/40VFn2',
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
