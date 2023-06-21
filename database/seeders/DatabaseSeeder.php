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
        // \App\Models\User::factory(10)->create();
        \App\Models\User::create([
            "name" => "Admin",
            "role_name" => "admin",
            "email" => "msabilfaustaa@gmail.com",
            "password" => bcrypt("adminsabil"),
        ]);

        $this->call([
            KategoriMenuSeeder::class,
            GuestSeeder::class,
        ]);
    }
}
