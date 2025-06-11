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
        Schema::create('quiz_matches', function (Blueprint $table) {
            $table->string('id')->primary(); // UUID non auto-incrémenté
            $table->string('quiz_code_id'); // Clé étrangère vers quizzes.code_id
            $table->string('status')->default('pending'); // Statut du match
            $table->timestamp('created_date')->useCurrent(); // Seulement created_date
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_matches');
    }
};