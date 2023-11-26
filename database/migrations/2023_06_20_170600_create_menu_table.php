<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('nama_menu');
            $table->text('deskripsi');
            $table->string('img');
            $table->double('harga');
            $table->integer('stok');
            $table->unsignedBigInteger('kategori_menu_id');

            $table->timestamps();
            $table->foreign('kategori_menu_id')->references('id')->on('kategori_menu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
