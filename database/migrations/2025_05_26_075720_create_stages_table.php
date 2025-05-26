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
        Schema::create('stages', function (Blueprint $table) {
            // Clé primaire personnalisée
            $table->integer('code_id')->primary();

            // Foreign key vers quizzes.code_id
            $table->integer('quiz_code_id')->unsigned();
            $table->foreign('quiz_code_id')
                  ->references('code_id')
                  ->on('quizzes')
                  ->onDelete('cascade');

            // Colonnes métiers
            $table->integer('order');
            $table->integer('number_of_time_to_use');

            // Timestamps Laravel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stages', function (Blueprint $table) {
            $table->dropForeign(['quiz_code_id']);
            $table->dropPrimary(['code_id']);
        });

        Schema::dropIfExists('stages');
    }
};