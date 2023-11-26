<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMenu extends Model
{
    use HasFactory;
    protected $table = "kategori_menu";
    protected $guarded = ["id"];

    public function menu()
    {
        return $this->hasMany(Menu::class);
    }
}
