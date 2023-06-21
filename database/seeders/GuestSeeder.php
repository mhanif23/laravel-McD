<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            "name" => "Guest 1",
            "role_name" => "guest",
            "email" => "guest-1@gmail.com",
            "password" => bcrypt("12345678"),
        ]);
        \App\Models\User::create([
            "name" => "Guest 2",
            "role_name" => "guest",
            "email" => "guest-2@gmail.com",
            "password" => bcrypt("12345678"),
        ]);
        \App\Models\User::create([
            "name" => "Guest 3",
            "role_name" => "guest",
            "email" => "guest-3@gmail.com",
            "password" => bcrypt("12345678"),
        ]);
        \App\Models\User::create([
            "name" => "Guest 4",
            "role_name" => "guest",
            "email" => "guest-4@gmail.com",
            "password" => bcrypt("12345678"),
        ]);
    }
}
