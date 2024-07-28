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
        Schema::create('penerima', function (Blueprint $table) {

            $gocap = DB::connection('gocap')->getDatabaseName();

            $table->uuid('id_penerima')->primary()->default();
            $table->foreignUuid('id_kategori');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori');
            $table->enum('penerima', [1, 0]);
            $table->enum('pemohon', [1, 0]);
            $table->enum('jenis', ['Entitas', 'Perorangan']);
            $table->enum('golongan', ['Fakir', 'Miskin', 'Ghorimin', 'Amil', 'Fisabilillah', 'Ibnus sabil', 'Muallaf', 'Riqab'])->nullable();

            $table->string('nama')->nullable();
            $table->string('nik')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('nohp')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('foto')->nullable();
            $table->string('alamat')->nullable();

            // entitas/lembaga
            $table->string('nomor_registrasi')->nullable();
            $table->string('nomor_perijinan')->nullable();
            $table->string('nama_lembaga')->nullable();
            $table->string('nama_pimpinan')->nullable();
            $table->text('alamat_lembaga')->nullable();

            // foreign key pc/upzis/ranting
            $table->foreignUuid('id_pc')->nullable();
            $table->foreign('id_pc')->references('id_pc')->on(new Expression($gocap . '.pc'));
            $table->foreignUuid('id_upzis')->nullable();
            $table->foreign('id_upzis')->references('id_upzis')->on(new Expression($gocap . '.upzis'));
            $table->foreignUuid('id_ranting')->nullable();
            $table->foreign('id_ranting')->references('id_ranting')->on(new Expression($gocap . '.ranting'));

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
        Schema::dropIfExists('penerima');
    }
};
