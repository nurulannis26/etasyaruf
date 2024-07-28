<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Expression;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_berita', function (Blueprint $table) {

            $gocap = DB::connection('gocap')->getDatabaseName();
            $siftnu = DB::connection('siftnu')->getDatabaseName();

            $table->uuid('id_file_berita')->primary();

            // foreign key permohonan
            $table->foreignUuid('id_berita_umum')->nullable();
            $table->foreign('id_berita_umum')->references('id_berita_umum')->on('berita')->cascadeOnDelete();



            // foreign key siftnu id wilayah



            $table->string('judul_file')->nullable();

            $table->string('foto_background_berita')->nullable();
            $table->string('foto_dokumentasi_berita')->nullable();



            // foreign key gocap (maker/pembuat)
            $table->foreignUuid('id_pengguna')->nullable();
            $table->foreign('id_pengguna')->references('id_pengguna')->on(new Expression($siftnu . '.pengguna'));



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
        Schema::dropIfExists('pengajuan_berita');
    }
};
