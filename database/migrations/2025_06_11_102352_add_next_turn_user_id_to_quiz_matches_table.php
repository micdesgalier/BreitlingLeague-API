<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz_matches', function (Blueprint $table) {
            // Si user_id est integer :
            $table->unsignedBigInteger('next_turn_user_id')->nullable()->after('status');
            // Optionnel : si tu veux contraindre en FK
            $table->foreign('next_turn_user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('quiz_matches', function (Blueprint $table) {
            $table->dropForeign(['next_turn_user_id']);
            $table->dropColumn('next_turn_user_id');
        });
    }
};