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
        Schema::create('user_activity_group_activity_results', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('activity_group_activity_id');
            $table->boolean('is_completed')->default(false);
            $table->dateTime('completion_date')->nullable();
            $table->float('score')->default(0);
            $table->float('score_percent')->default(0);
            $table->boolean('has_improved_score')->default(false);

            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_activity_group_activity_results', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('user_activity_group_activity_results');
    }
};