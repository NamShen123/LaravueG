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
        Schema::table('call_slip', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained(
                table: 'users'
            );
            $table->foreignId('staff_id')->constrained(
                table: 'users'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['staff_id']);
            $table->dropColumn(['user_id', 'staff_id']);
        });
    }
};
