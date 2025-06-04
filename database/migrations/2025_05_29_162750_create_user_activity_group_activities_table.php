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
        Schema::create('user_activity_group_activities', function (Blueprint $table) {
            $table->id();

            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->float('progression_score')->nullable();
            $table->float('progression_score_percent')->nullable();
            $table->unsignedBigInteger('external_id')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('activity_group_activity_id');
            $table->unsignedBigInteger('activity_result_id')->nullable();

            // Foreign keys
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('activity_result_id')
                ->references('id')->on('activity_results')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_activity_group_activities', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['activity_result_id']);
        });

        Schema::dropIfExists('user_activity_group_activities');
    }
};