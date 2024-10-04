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
        Schema::create('call_slip_book', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::table('call_slip_book', function (Blueprint $table) {
            $table->foreignId('call_slip_id')->constrained(
                table: 'call_slip'
            );
            $table->foreignId('book_id')->constrained(
                table: 'books'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('call_slip_book', function (Blueprint $table) {
            $table->dropForeign(['call_slip_id']);
            $table->dropForeign(['book_id']);
            $table->dropColumn(['call_slip_id', 'book_id']);
        });

        Schema::dropIfExists('call_slip_book');
    }
};
