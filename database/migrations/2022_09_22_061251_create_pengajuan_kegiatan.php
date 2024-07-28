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
        Schema::create('pengajuan_kegiatan', function (Blueprint $table) {

            // $db = DB::connection('shifnu')->getDatabaseName();
            $gocap = DB::connection('gocap')->getDatabaseName();

            $table->uuid('id_pengajuan_kegiatan')->primary();
            $table->foreignUuid('id_pengajuan');
            $table->foreign('id_pengajuan')->references('id_pengajuan')->on('pengajuan')->cascadeOnDelete();
            $table->foreignUuid('id_pengajuan_detail');
            $table->foreign('id_pengajuan_detail')->references('id_pengajuan_detail')->on('pengajuan_detail')->cascadeOnDelete();


            $table->string('tgl_kegiatan')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('judul')->nullable();
            $table->string('jumlah_kehadiran')->nullable();
            $table->string('kendala')->nullable();
            $table->string('ringkasan')->nullable();

            $table->foreignUuid('maker_tingkat_pc')->nullable();
            $table->foreign('maker_tingkat_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->foreignUuid('maker_tingkat_upzis')->nullable();
            $table->foreign('maker_tingkat_upzis')->references('id_upzis_pengurus')->on(new Expression($gocap . '.upzis_pengurus'));

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
        Schema::dropIfExists('pengajuan_kegiatan');
    }
};
