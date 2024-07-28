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
        Schema::create('pengeluaran_internal', function (Blueprint $table) {

            $gocap = DB::connection('gocap')->getDatabaseName();

            $table->uuid('id_pengeluaran_internal')->primary();

            // foreign key permohonan
            $table->foreignUuid('id_pengajuan_internal');
            $table->foreign('id_pengajuan_internal')->references('id_pengajuan_internal')->on('pengajuan_internal')->cascadeOnDelete();

            $table->string('judul')->nullable();
            $table->date('tgl_pengeluaran')->nullable();
            $table->string('jumlah')->nullable();
            $table->integer('nominal_pengeluaran')->nullable();
            // $table->integer('saldo_akhir')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('file')->nullable();

            // foreign key gocap(maker/pembuat)
            $table->foreignUuid('maker_tingkat_pc')->nullable();;
            $table->foreign('maker_tingkat_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            // $table->foreignUuid('maker_tingkat_upzis')->nullable();;
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
        Schema::dropIfExists('pengeluaran_internal');
    }
};
