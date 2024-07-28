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
        Schema::create('pengajuan_internal', function (Blueprint $table) {

            $gocap = DB::connection('gocap')->getDatabaseName();

            $table->uuid('id_pengajuan_internal')->primary();
            $table->string('nomor_pengajuan')->nullable();
            $table->date('tgl_pengajuan')->nullable();

            $table->foreignUuid('id_pc')->nullable();;
            $table->foreign('id_pc')->references('id_pc')->on(new Expression($gocap . '.pc'));
            // $table->foreignUuid('id_upzis')->nullable();;
            // $table->foreign('id_upzis')->references('id_upzis')->on(new Expression($gocap . '.upzis'));

            $table->integer('nominal_pengajuan')->nullable();
            $table->integer('nominal_disetujui')->nullable();
            $table->enum('bentuk_pencairan', ['Cash', 'Transfer']);
            $table->string('bank_tujuan')->nullable();
            $table->string('rekening_tujuan')->nullable();
            $table->string('atasnama')->nullable();
            $table->enum('penggunaan_dana', ['Uang Muka', 'Reimbursement', 'Pembayaran', 'Lainnya']);
            $table->date('tgl_tenggat_pencairan')->nullable();
            $table->string('keterangan')->nullable();

            // acc
            $table->enum('approval_status', ['Belum Direspon', 'Ditolak', 'Disetujui'])->nullable();
            $table->date('approval_date')->nullable();
            $table->text('approval_note')->nullable();
            $table->date('denial_date')->nullable();
            $table->text('denial_note')->nullable();


            // pencairan
            $table->enum('pencairan_status', ['Belum Dicairkan', 'Berhasil Dicairkan'])->nullable();
            $table->date('tgl_pencairan')->nullable();
            $table->foreignUuid('dicairkan_kepada')->nullable();
            $table->foreign('dicairkan_kepada')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->integer('nominal_pencairan')->nullable();
            $table->string('file')->nullable();
            $table->string('pencairan_note')->nullable();

            $table->foreignUuid('id_rekening')->nullable();
            $table->foreign('id_rekening')->references('id_rekening')->on(new Expression($gocap . '.rekening'));


            $table->foreignUuid('approver_tingkat_pc')->nullable();
            $table->foreign('approver_tingkat_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->foreignUuid('denial_tingkat_pc')->nullable();
            $table->foreign('denial_tingkat_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));

            // foreign key gocap
            $table->foreignUuid('diajukan_oleh_pc')->nullable();
            $table->foreign('diajukan_oleh_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            // $table->foreignUuid('diajukan_oleh_upzis')->nullable();
            // $table->foreign('diajukan_oleh_upzis')->references('id_upzis_pengurus')->on(new Expression($gocap . '.upzis_pengurus'));
            $table->foreignUuid('disetujui_oleh_pc')->nullable();
            $table->foreign('disetujui_oleh_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            // $table->foreignUuid('disetujui_oleh_upzis')->nullable();
            // $table->foreign('disetujui_oleh_upzis')->references('id_upzis_pengurus')->on(new Expression($gocap . '.upzis_pengurus'));
            $table->foreignUuid('staf_keuangan_pc')->nullable();
            $table->foreign('staf_keuangan_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));



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
        Schema::dropIfExists('pengajuan_internal');
    }
};
