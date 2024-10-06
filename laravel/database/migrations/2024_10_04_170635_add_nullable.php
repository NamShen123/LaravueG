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
        Schema::table('books', function ($table) {
            $table->string('image')->nullable()->change();
        });

        Schema::table('call_slip', function ($table) {
            $table->timestamp('return_date')->nullable(true)->change();
            $table->unsignedBigInteger('staff_id')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('call_slip', function ($table) {
            $table->timestamp('return_date')->nullable(false)->change();
            $table->unsignedBigInteger('staff_id')->nullable(false)->change();
        });

        Schema::table('books', function ($table) {
            $table->string('image')->nullable(false)->change();
        });
    }
};
