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
        Schema::create('quizzes', function (Blueprint $table) {
            // Clé primaire personnalisée
            $table->string('code_id')->primary();

            // Colonnes métiers
            $table->string('type');
            $table->integer('label_translation_code_id')->unsigned();
            $table->string('shuffle_type');
            $table->string('shuffle_scope');
            $table->string('draw_type');
            $table->integer('max_user_attempt');
            $table->boolean('is_unlimited');
            $table->integer('duration');
            $table->integer('question_duration');
            $table->integer('correct_choice_points');
            $table->integer('wrong_choice_points');

            // Timestamps Laravel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropPrimary(['code_id']);
        });

        Schema::dropIfExists('quizzes');
    }
};