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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('')->constrained(
                table: 'departments'
            );
            $table->foreignId('status_id')->constrained(
                table: 'user_status'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['']);
            $table->dropForeign(['status_id']);
            $table->dropColumn(['', 'status_id']);
        });
    }
};
