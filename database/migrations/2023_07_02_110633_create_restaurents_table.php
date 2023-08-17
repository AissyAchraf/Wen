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
        Schema::create('restaurents', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->longText('address');
            $table->longText('description');
            $table->string('photos')->nullable();
            $table->integer('capacity')->nullable();
            $table->string('cuisine')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurents');
    }
};
