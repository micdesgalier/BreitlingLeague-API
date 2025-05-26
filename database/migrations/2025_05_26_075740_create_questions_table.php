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
        Schema::create('questions', function (Blueprint $table) {
            // Clé primaire personnalisée
            $table->integer('code_id')->primary();

            // Colonnes métiers
            $table->integer('label_translation_code_id')->unsigned()->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('media_id')->unsigned()->nullable();
            $table->string('type');
            $table->boolean('is_choice_shuffle')->default(false);
            $table->string('correct_value');

            // Clés étrangères optionnelles
            $table->foreign('label_translation_code_id')
                  ->references('code_id')
                  ->on('label_translations')
                  ->onDelete('set null');

            $table->foreign('media_id')
                  ->references('id')
                  ->on('media')
                  ->onDelete('set null');

            // Timestamps Laravel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['label_translation_code_id']);
            $table->dropForeign(['media_id']);
            $table->dropPrimary(['code_id']);
        });

        Schema::dropIfExists('questions');
    }
};