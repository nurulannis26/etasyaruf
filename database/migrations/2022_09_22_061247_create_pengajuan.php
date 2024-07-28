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
        Schema::create('pengajuan', function (Blueprint $table) {

            $gocap = DB::connection('gocap')->getDatabaseName();

            $table->uuid('id_pengajuan')->primary();
            $table->enum('tingkat', ['PC', 'Upzis MWCNU', 'Ranting NU']);
            $table->string('nomor_surat')->nullable();
            $table->date('tgl_pengajuan')->nullable();
            $table->date('tgl_konfirmasi')->nullable();
            $table->date('tgl_terbit_rekomendasi')->nullable();
            $table->enum('status_pengajuan', ['Direncanakan', 'Diajukan']);
            $table->enum('status_rekomendasi', ['Belum Terbit', 'Sudah Terbit']);
            $table->foreignUuid('pj_pc')->nullable();
            $table->foreign('pj_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->foreignUuid('pj_upzis')->nullable();
            $table->foreign('pj_upzis')->references('id_upzis_pengurus')->on(new Expression($gocap . '.upzis_pengurus'));
            $table->string('scan')->nullable();
            $table->string('scan_rekomendasi')->nullable();
            $table->foreignUuid('dikonfirmasi_oleh_upzis')->nullable();
            $table->foreign('dikonfirmasi_oleh_upzis')->references('id_upzis_pengurus')->on(new Expression($gocap . '.upzis_pengurus'));
            $table->foreignUuid('direkomendasikan_oleh_pc')->nullable();
            $table->foreign('direkomendasikan_oleh_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->foreignUuid('direkomendasikan_oleh_upzis')->nullable();
            $table->foreign('direkomendasikan_oleh_upzis')->references('id_upzis_pengurus')->on(new Expression($gocap . '.upzis_pengurus'));
            // $table->string('memo_internal')->nullable();

            // foreign key gocap
            // $table->foreignUuid('pj_tingkat_pc')->nullable();
            // $table->foreign('pj_tingkat_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            // $table->foreignUuid('pj_tingkat_upzis')->nullable();
            // $table->foreign('pj_tingkat_upzis')->references('id_upzis_pengurus')->on(new Expression($gocap . '.upzis_pengurus'));
            // $table->foreignUuid('pj_tingkat_ranting')->nullable();
            // $table->foreign('pj_tingkat_ranting')->references('id_ranting_pengurus')->on(new Expression($gocap . '.ranting_pengurus'));
            $table->foreignUuid('id_pc')->nullable();;
            $table->foreign('id_pc')->references('id_pc')->on(new Expression($gocap . '.pc'));
            $table->foreignUuid('id_upzis')->nullable();;
            $table->foreign('id_upzis')->references('id_upzis')->on(new Expression($gocap . '.upzis'));
            $table->foreignUuid('id_ranting')->nullable();
            $table->foreign('id_ranting')->references('id_ranting')->on(new Expression($gocap . '.ranting'));


            // foreign key penerima 
            // $table->foreignUuid('id_penerima');
            // $table->foreign('id_penerima')->references('id_penerima')->on('penerima');



            // // survey
            // $table->date('tgl_survey')->nullable();
            // $table->enum('survey_status', ['Belum Disurvey', 'Disetujui & Direkomendasikan', 'Ditolak'])->nullable();
            // // $table->string('hasil')->nullable();
            // $table->string('lokasi')->nullable();
            // $table->text('survey_note')->nullable();
            // $table->text('denial_survey_note')->nullable();
            // $table->date('denial_tgl_survey')->nullable();




            // keuangan
            // $table->enum('pencairan_status', ['Belum Dicairkan', 'Berhasil Dicairkan'])->nullable();
            // $table->date('tgl_pencairan')->nullable();
            // $table->foreignUuid('dicairkan_kepada')->nullable();
            // $table->foreign('dicairkan_kepada')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            // $table->integer('nominal_pencairan')->nullable();
            // $table->integer('sisa')->nullable();
            // $table->string('file')->nullable();
            // $table->string('pencairan_note')->nullable();


            // foreign key gocap (maker/pembuat)
            $table->foreignUuid('maker_tingkat_pc')->nullable();
            $table->foreign('maker_tingkat_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->foreignUuid('maker_tingkat_upzis')->nullable();
            $table->foreign('maker_tingkat_upzis')->references('id_upzis_pengurus')->on(new Expression($gocap . '.upzis_pengurus'));

            // // survey
            // $table->foreignUuid('staf_program_pc')->nullable();
            // $table->foreign('staf_program_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            // // pencairan
            // $table->foreignUuid('staf_keuangan_pc')->nullable();
            // $table->foreign('staf_keuangan_pc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));

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
        Schema::dropIfExists('pengajuan');
    }
};
