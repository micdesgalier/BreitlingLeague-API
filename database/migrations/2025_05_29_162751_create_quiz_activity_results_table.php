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
        Schema::create('quiz_activity_results', function (Blueprint $table) {
            $table->id();
            $table->float('score')->default(0);
            $table->unsignedInteger('correct_answer_count')->default(0);
            $table->unsignedBigInteger('activity_result_id');

            // Foreign key constraint
            $table->foreign('activity_result_id')
                ->references('id')
                ->on('activity_results')
                ->onDelete('cascade');

            // Pas de timestamps (conformément au modèle)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_activity_results', function (Blueprint $table) {
            $table->dropForeign(['activity_result_id']);
        });

        Schema::dropIfExists('quiz_activity_results');
    }
};