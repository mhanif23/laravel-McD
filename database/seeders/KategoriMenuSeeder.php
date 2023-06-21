<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KategoriMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\KategoriMenu::create([
            "nama_kategori" => "Main Course",
        ]);
        \App\Models\KategoriMenu::create([
            "nama_kategori" => "Snacks",
        ]);
        \App\Models\KategoriMenu::create([
            "nama_kategori" => "Coffee",
        ]);
        \App\Models\KategoriMenu::create([
            "nama_kategori" => "Non Coffee",
        ]);
        \App\Models\KategoriMenu::create([
            "nama_kategori" => "Mocktails",
        ]);
    }
}
