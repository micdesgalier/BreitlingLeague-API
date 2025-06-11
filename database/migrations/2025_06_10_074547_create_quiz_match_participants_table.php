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
        Schema::create('quiz_match_participants', function (Blueprint $table) {
            $table->string('id')->primary(); // UUID comme clé primaire

            $table->string('quiz_match_id'); // FK vers quiz_matches
            $table->unsignedBigInteger('user_id'); // FK vers users

            $table->string('invitation_state')->default('pending');
            $table->timestamp('last_answer_date')->nullable();
            $table->integer('score')->default(0);
            $table->integer('points_bet')->default(0);
            $table->boolean('is_winner')->default(false);

            $table->timestamps(); // created_at et updated_at

            // Contraintes de clé étrangère
            $table->foreign('quiz_match_id')->references('id')->on('quiz_matches')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_match_participants');
    }
};