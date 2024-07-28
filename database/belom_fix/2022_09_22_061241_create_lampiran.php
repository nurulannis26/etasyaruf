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
        Schema::create('lampiran', function (Blueprint $table) {

            // $db = DB::connection('shifnu')->getDatabaseName();

            $table->uuid('id_lampiran')->primary();

            $table->foreignUuid('id_pengajuan_umum');
            $table->foreign('id_pengajuan_umum')->references('id_pengajuan_umum')->on('pengajuan_umum')->cascadeOnDelete();
            $table->foreignUuid('id_pengajuan_internal');
            $table->foreign('id_pengajuan_internal')->references('id_pengajuan_internal')->on('pengajuan_internal')->cascadeOnDelete();


            $table->string('judul')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('lampiran');
    }
};
