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
        Schema::create('quiz_match_answers', function (Blueprint $table) {
            $table->string('id')->primary(); // UUID comme clé primaire
            $table->string('quiz_match_id');
            $table->string('quiz_match_participant_id');
            $table->string('quiz_match_question_id');
            $table->string('choice_code_id');
            $table->boolean('is_correct')->default(false);
            $table->timestamp('answer_date')->nullable();
            $table->timestamps(); // created_at et updated_at

            // Clés étrangères (optionnel mais recommandé)
            $table->foreign('quiz_match_id')->references('id')->on('quiz_matches')->onDelete('cascade');
            $table->foreign('quiz_match_participant_id')->references('id')->on('quiz_match_participants')->onDelete('cascade');
            $table->foreign('quiz_match_question_id')->references('id')->on('quiz_match_questions')->onDelete('cascade');
            $table->foreign('choice_code_id')->references('code_id')->on('choices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_match_answers');
    }
};