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
        Schema::create('program_kegiatan', function (Blueprint $table) {

            // $db = DB::connection('shifnu')->getDatabaseName();

            $table->uuid('id_program_kegiatan')->primary();
            $table->foreignUuid('id_program_pilar');
            $table->foreign('id_program_pilar')->references('id_program_pilar')->on('program_pilar')->cascadeOnDelete();
            $table->string('no_urut')->nullable();
            $table->string('nama_program')->nullable();
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
        Schema::dropIfExists('program_kegiatan');
    }
};
