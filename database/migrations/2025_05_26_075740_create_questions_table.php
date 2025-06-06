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
            $table->string('code_id')->primary();

            // Colonnes métiers
            $table->string('label')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('media_id')->unsigned()->nullable();
            $table->string('type');
            $table->boolean('is_choice_shuffle')->default(false);
            $table->string('correct_value');

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
            $table->dropPrimary(['code_id']);
        });

        Schema::dropIfExists('questions');
    }
};