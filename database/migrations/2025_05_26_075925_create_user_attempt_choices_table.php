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
        Schema::create('user_attempt_choices', function (Blueprint $table) {
            $table->id();

            // ✅ Changement ici : on remplace user_attempt_id par user_attempt_question_id
            $table->unsignedBigInteger('user_attempt_question_id');
            $table->unsignedInteger('choice_code_id');

            $table->boolean('is_selected')->default(false);
            $table->boolean('is_correct')->default(false);

            // ✅ Mise à jour des clés étrangères
            $table->foreign('user_attempt_question_id')
                ->references('id')
                ->on('user_attempt_questions')
                ->onDelete('cascade');

            $table->foreign('choice_code_id')
                ->references('code_id')
                ->on('choices')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_attempt_choices', function (Blueprint $table) {
            $table->dropForeign(['user_attempt_question_id']);
            $table->dropForeign(['choice_code_id']);
        });

        Schema::dropIfExists('user_attempt_choices');
    }
};