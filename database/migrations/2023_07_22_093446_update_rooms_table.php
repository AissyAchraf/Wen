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
        Schema::table('rooms', function (Blueprint $table) {
            $table->float('surface');
            $table->string('room_type');
            $table->string('beds_type');
            $table->integer('capacity');
            $table->string('amenities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('surface');
            $table->dropColumn('room_type');
            $table->dropColumn('beds_type');
            $table->dropColumn('capacity');
            $table->dropColumn('amenities');
        });
    }
};
