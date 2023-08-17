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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id()->autoIncrements();
            $table->unsignedBigInteger('type_id');
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();
            $table->boolean('status');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('chalet_id');
            $table->unsignedBigInteger('restaurant_id');
            $table->foreign('type_id')->references('id')->on('subscription_types')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->foreign('chalet_id')->references('id')->on('chalets')->onDelete('cascade');
            $table->foreign('restaurant_id')->references('id')->on('restaurents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
