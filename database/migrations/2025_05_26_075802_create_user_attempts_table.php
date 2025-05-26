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
        Schema::create('user_attempts', function (Blueprint $table) {
            $table->id();

            // Colonnes métiers
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

            $table->unsignedInteger('quiz_code_id');
            $table->unsignedBigInteger('user_id');

            $table->boolean('is_completed')->default(false);

            $table->integer('duration')->nullable();
            $table->integer('score')->nullable();
            $table->integer('initial_score')->nullable();
            $table->integer('combo_bonus_score')->nullable();
            $table->integer('time_bonus_score')->nullable();

            // Clés étrangères
            $table->foreign('quiz_code_id')
                ->references('code_id')
                ->on('quizzes')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::table('user_attempts', function (Blueprint $table) {
            $table->dropForeign(['quiz_code_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('user_attempts');
    }
};