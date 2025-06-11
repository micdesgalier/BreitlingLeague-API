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
        Schema::create('quiz_match_questions', function (Blueprint $table) {
            $table->string('id')->primary(); // UUID comme clé primaire

            $table->string('quiz_match_id');       // FK vers quiz_matches
            $table->string('question_code_id');  // FK vers questions.code_id
            $table->integer('order')->default(0); // ordre de la question dans le match

            $table->timestamps(); // created_at et updated_at

            // Clés étrangères
            $table->foreign('quiz_match_id')->references('id')->on('quiz_matches')->onDelete('cascade');
            $table->foreign('question_code_id')->references('code_id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_match_questions');
    }
};