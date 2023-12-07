<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            [
                'name' => 'sharpsss',
                'email' => 'sasha.butko@list.ru',
                'password' => Hash::make('1234gghh'),
            ],
            [
                'name' => 'test_userone',
                'email' => 'user2@example.com',
                'password' => Hash::make('password2'),
            ],
            [
                'name' => 'test_usertwo',
                'email' => 'user3@example.com',
                'password' => Hash::make('password3'),
            ],
        ]);
    }
}
