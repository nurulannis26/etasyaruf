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
        Schema::create('bentuk_program', function (Blueprint $table) {

            // $db = DB::connection('shifnu')->getDatabaseName();

            $table->uuid('id_bentuk_program')->primary();
            $table->foreignUuid('id_program');
            $table->foreign('id_program')->references('id_program')->on('program')->cascadeOnDelete();
            $table->string('bentuk_program')->nullable();
            $table->string('kode')->nullable();
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
        Schema::dropIfExists('bentuk_program');
    }
};
