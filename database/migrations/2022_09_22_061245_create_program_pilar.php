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
        Schema::create('program_pilar', function (Blueprint $table) {

            // $db = DB::connection('shifnu')->getDatabaseName();

            $table->uuid('id_program_pilar')->primary();
            // foreign key program
            $table->foreignUuid('id_program')->nullable();
            $table->foreign('id_program')->references('id_program')->on('program')->cascadeOnDelete();
            $table->foreignUuid('id_program2')->nullable();
            $table->foreign('id_program2')->references('id_program')->on('program')->cascadeOnDelete();

            $table->string('pilar')->nullable();
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
        Schema::dropIfExists('program_pilar');
    }
};
