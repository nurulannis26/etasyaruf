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
        Schema::create('berita', function (Blueprint $table) {

            $gocap = DB::connection('gocap')->getDatabaseName();
            $siftnu = DB::connection('siftnu')->getDatabaseName();

            $table->uuid('id_berita_umum')->primary();

            // foreign key permohonan
            $table->foreignUuid('id_pengajuan')->nullable();
            $table->foreign('id_pengajuan')->references('id_pengajuan')->on('pengajuan')->cascadeOnDelete();
            $table->foreignUuid('id_pengajuan_detail')->nullable();
            $table->foreign('id_pengajuan_detail')->references('id_pengajuan_detail')->on('pengajuan_detail')->cascadeOnDelete();


            // foreign key siftnu id wilayah
            // $table->foreign('pj_tingkat_ranting')->references('id_ranting_pengurus')->on(new Expression($gocap . '.ranting_pengurus'));
            $table->foreignUuid('id_pc')->nullable();;
            $table->foreign('id_pc')->references('id_pc')->on(new Expression($gocap . '.pc'));
            $table->foreignUuid('id_upzis')->nullable();;
            $table->foreign('id_upzis')->references('id_upzis')->on(new Expression($gocap . '.upzis'));
            $table->foreignUuid('id_ranting')->nullable();
            $table->foreign('id_ranting')->references('id_ranting')->on(new Expression($gocap . '.ranting'));
            $table->string('kategori_berita')->nullable();
            $table->string('hastag_berita')->nullable();


            $table->string('judul_berita')->nullable();
            $table->text('narasi_berita')->nullable();
            $table->string('foto_background_berita')->nullable();
            $table->string('foto_dokumentasi_berita')->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->enum('status', ['Belum Diinput', 'Belum Terbit', 'Sudah Terbit'])->nullable();

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
