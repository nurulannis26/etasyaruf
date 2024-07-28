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
        Schema::create('pengajuan_detail', function (Blueprint $table) {

            $gocap = DB::connection('gocap')->getDatabaseName();

            $table->uuid('id_pengajuan_detail')->primary();
            $table->foreignUuid('id_pengajuan');
            $table->foreign('id_pengajuan')->references('id_pengajuan')->on('pengajuan')->cascadeOnDelete();
            $table->string('nama_pemohon')->nullable();
            $table->string('nohp_pemohon')->nullable();
            $table->string('alamat_pemohon')->nullable();
            $table->foreignUuid('petugas_pc')->nullable();
            $table->foreign('petugas_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->foreignUuid('petugas_upzis')->nullable();
            $table->foreign('petugas_upzis')->references('id_upzis_pengurus')->on(new Expression($gocap . '.upzis_pengurus'));
            $table->date('tgl_pelaksanaan')->nullable();
            $table->date('tgl_setor')->nullable();

            // foreign key program
            $table->foreignUuid('id_program');
            $table->foreign('id_program')->references('id_program')->on('program');
            $table->foreignUuid('id_program_pilar');
            $table->foreign('id_program_pilar')->references('id_program_pilar')->on('program_pilar');
            $table->foreignUuid('id_program_kegiatan');
            $table->foreign('id_program_kegiatan')->references('id_program_kegiatan')->on('program_kegiatan');
            $table->string('nama_penerima')->nullable();
            $table->integer('jumlah_penerima')->nullable();
            $table->integer('satuan_pengajuan')->nullable();
            $table->integer('satuan_disetujui')->nullable();
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
            $table->integer('satuan_pencairan')->nullable();
            $table->integer('nominal_pencairan')->nullable();
            // $table->string('file')->nullable();
            $table->string('pencairan_note')->nullable();
            $table->foreignUuid('staf_keuangan_pc')->nullable();
            $table->foreign('staf_keuangan_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));

            $table->foreignUuid('id_rekening')->nullable();
            $table->foreign('id_rekening')->references('id_rekening')->on(new Expression($gocap . '.rekening'));
            // direktur
            $table->foreignUuid('approver_tingkat_pc')->nullable();
            $table->foreign('approver_tingkat_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->foreignUuid('denial_tingkat_pc')->nullable();
            $table->foreign('denial_tingkat_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));

            // foreign key gocap (maker/pembuat)
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
        Schema::dropIfExists('pengajuan_detail');
    }
};
