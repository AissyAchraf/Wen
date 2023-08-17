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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id()->autoIncrements();
            $table->unsignedBigInteger('reservation_id');
            $table->longText('comment');
            $table->float('star_rating');
            $table->boolean('status');
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('restaurent_id');
            $table->unsignedBigInteger('chalet_id');
            $table->unsignedBigInteger('dish_id');
            $table->timestamps();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->foreign('restaurent_id')->references('id')->on('restaurents')->onDelete('cascade');
            $table->foreign('chalet_id')->references('id')->on('chalets')->onDelete('cascade');
            $table->foreign('dish_id')->references('id')->on('dishs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
