<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id('id_mahasiswa');
            $table->string('email', 40)->unique();
            $table->string('nim', 10)->index();
            $table->string('nama', 25);
            $table->string('kelas', 5);
            $table->string('jurusan', 35);
            $table->string('tanggalLahir', 15);
            $table->string('alamat', 25);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}
