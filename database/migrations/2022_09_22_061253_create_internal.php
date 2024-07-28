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
        Schema::create('internal', function (Blueprint $table) {

            $gocap = DB::connection('gocap')->getDatabaseName();

            $table->uuid('id_internal')->primary();
            $table->string('nomor_surat')->nullable();
            $table->date('tgl_pengajuan')->nullable();
            $table->date('tgl_tenggat')->nullable();
            $table->enum('tujuan', ['Uang Muka', 'Reimbursement', 'Pembayaran', 'Lainnya']);
            $table->enum('bentuk', ['Cash', 'Transfer']);

            $table->string('atas_nama')->nullable();
            $table->string('bank_tujuan')->nullable();
            $table->string('no_rek_tujuan')->nullable();
            $table->string('note')->nullable();

            $table->integer('nominal_pengajuan')->nullable();
            $table->integer('nominal_disetujui')->nullable();
            $table->enum('approval_status', ['Belum Direspon', 'Ditolak', 'Disetujui'])->nullable();
            $table->text('approval_note')->nullable();
            $table->date('approval_date')->nullable();
            $table->text('denial_note')->nullable();
            $table->date('denial_date')->nullable();

            $table->enum('pencairan_status', ['Belum Dicairkan', 'Berhasil Dicairkan'])->nullable();
            $table->date('tgl_pencairan')->nullable();
            $table->foreignUuid('dicairkan_kepada')->nullable();
            $table->foreign('dicairkan_kepada')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->integer('nominal_pencairan')->nullable();
            // $table->string('file')->nullable();
            $table->string('pencairan_note')->nullable();
            $table->foreignUuid('id_rekening')->nullable();
            $table->foreign('id_rekening')->references('id_rekening')->on(new Expression($gocap . '.rekening'));

            $table->foreignUuid('id_pc')->nullable();;
            $table->foreign('id_pc')->references('id_pc')->on(new Expression($gocap . '.pc'));

            $table->foreignUuid('approver_tingkat_pc')->nullable();
            $table->foreign('approver_tingkat_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->foreignUuid('denial_tingkat_pc')->nullable();
            $table->foreign('denial_tingkat_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->foreignUuid('staf_keuangan_pc')->nullable();
            $table->foreign('staf_keuangan_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));

            $table->foreignUuid('maker_tingkat_pc')->nullable();
            $table->foreign('maker_tingkat_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));


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
        Schema::dropIfExists('internal');
    }
};
