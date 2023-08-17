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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id()->autoIncrements();
            $table->unsignedBigInteger('client_id');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->float('amount');
            $table->boolean('online_payement');      
            $table->string('status');    
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('chalet_id')->nullable();
            $table->unsignedBigInteger('table_id')->nullable();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('chalet_id')->references('id')->on('chalets')->onDelete('cascade');
            $table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
