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
        Schema::create('user_attempt_questions', function (Blueprint $table) {
            $table->id();

            // Colonnes métiers
            $table->unsignedBigInteger('user_attempt_id');
            $table->unsignedInteger('question_code_id');
            $table->integer('order')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->integer('score')->nullable();
            $table->integer('combo_bonus_value')->nullable();

            // Clés étrangères
            $table->foreign('user_attempt_id')
                ->references('id')
                ->on('user_attempts')
                ->onDelete('cascade');

            $table->foreign('question_code_id')
                ->references('code_id')
                ->on('questions')
                ->onDelete('cascade');

            // Timestamps Laravel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_attempt_questions', function (Blueprint $table) {
            $table->dropForeign(['user_attempt_id']);
            $table->dropForeign(['question_code_id']);
        });

        Schema::dropIfExists('user_attempt_questions');
    }
};