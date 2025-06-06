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
        Schema::create('choices', function (Blueprint $table) {
            $table->string('code_id')->primary();
            $table->unsignedBigInteger('media_id')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_correct')->default(false);
            $table->string('question_code_id');

            // Ajout de la colonne 'label' pour le texte du choix
            $table->text('label');

            $table->timestamps();

            // Foreign key vers questions.code_id
            $table->foreign('question_code_id')
                  ->references('code_id')
                  ->on('questions')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('choices');
    }
};