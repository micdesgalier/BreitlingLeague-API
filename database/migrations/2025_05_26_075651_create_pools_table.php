<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pools', function (Blueprint $table) {
            // Clé primaire personnalisée
            $table->string('code_id')->primary();

            // Foreign key vers stages.code_id
            $table->integer('stage_code_id')->unsigned();
            $table->foreign('stage_code_id')
                  ->references('code_id')
                  ->on('stages')
                  ->onDelete('cascade');

            // Colonnes métiers
            $table->integer('order');
            $table->integer('number_of_question');
            $table->integer('consecutive_correct_answer');
            $table->integer('minimum_correct_question');

            // Timestamps Laravel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pools', function (Blueprint $table) {
            $table->dropForeign(['stage_code_id']);
        });

        Schema::dropIfExists('pools');
    }
};