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
        Schema::create('pool_questions', function (Blueprint $table) {
            // Pas de $table->id(), on gère nous-mêmes la PK composite
            $table->string('pool_code_id');
            $table->string('question_code_id');
            $table->integer('order');

            // Déclaration de la PK composite
            $table->primary(['pool_code_id', 'question_code_id']);

            // Clés étrangères
            $table->foreign('pool_code_id')
                  ->references('code_id')
                  ->on('pools')
                  ->onDelete('cascade');

            $table->foreign('question_code_id')
                  ->references('code_id')
                  ->on('questions')
                  ->onDelete('cascade');

            // Pas de timestamps, pivot « read/write » uniquement
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pool_questions', function (Blueprint $table) {
            $table->dropForeign(['pool_code_id']);
            $table->dropForeign(['question_code_id']);
            $table->dropPrimary(['pool_code_id', 'question_code_id']);
        });

        Schema::dropIfExists('pool_questions');
    }
};