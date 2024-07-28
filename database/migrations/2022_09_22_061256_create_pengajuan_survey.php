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
        Schema::create('pengajuan_survey', function (Blueprint $table) {

            $gocap = DB::connection('gocap')->getDatabaseName();
            $siftnu = DB::connection('siftnu')->getDatabaseName();

            $table->uuid('id_pengajuan_survey')->primary();

            // foreign key permohonan
            $table->foreignUuid('id_pengajuan');
            $table->foreign('id_pengajuan')->references('id_pengajuan')->on('pengajuan')->cascadeOnDelete();
            $table->foreignUuid('id_pengajuan_detail');
            $table->foreign('id_pengajuan_detail')->references('id_pengajuan_detail')->on('pengajuan_detail')->cascadeOnDelete();

            $table->date('tgl_survey')->nullable();
            $table->text('survey_hasil')->nullable();
            $table->text('survey_lokasi')->nullable();
            $table->text('survey_catatan')->nullable();

            // foreign key gocap (maker/pembuat)
            $table->foreignUuid('staf_program')->nullable();
            $table->foreign('staf_program')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
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
        Schema::dropIfExists('pengajuan_survey');
    }
};
