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
        Schema::table('restaurents', function (Blueprint $table) {
            $table->unsignedBigInteger('user_manager')->nullable();
            $table->foreign('user_manager')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurents', function (Blueprint $table) {
            $table->dropColumn(['user_manager']);
        });
    }
};
