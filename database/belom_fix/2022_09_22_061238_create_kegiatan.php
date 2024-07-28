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
        Schema::create('kegiatan', function (Blueprint $table) {

            $gocap = DB::connection('gocap')->getDatabaseName();

            $table->uuid('id_kegiatan')->primary();

            // foreign key permohonan
            $table->foreignUuid('id_pengajuan_umum');
            $table->foreign('id_pengajuan_umum')->references('id_pengajuan_umum')->on('pengajuan_umum')->cascadeOnDelete();
            $table->foreignUuid('id_pengajuan_internal');
            $table->foreign('id_pengajuan_internal')->references('id_pengajuan_internal')->on('pengajuan_internal')->cascadeOnDelete();

            $table->string('judul')->nullable();
            $table->string('tgl_kegiatan')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('jumlah_kehadiran')->nullable();

            $table->enum('status', ['Belum Diinput', 'Direncanakan', 'Dilaksanakan'])->nullable();

            $table->string('ringkasan')->nullable();
            $table->string('kendala')->nullable();

            // foreign key gocap (maker/pembuat)
            $table->foreignUuid('maker_tingkat_pc')->nullable();
            $table->foreign('maker_tingkat_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            // $table->foreignUuid('maker_tingkat_upzis')->nullable();
            // $table->foreign('maker_tingkat_upzis')->references('id_upzis_pengurus')->on(new Expression($gocap . '.upzis_pengurus'));

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
        Schema::dropIfExists('kegiatan');
    }
};
