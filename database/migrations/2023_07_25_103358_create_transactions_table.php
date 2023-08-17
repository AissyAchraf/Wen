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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id()->autoIncrements();
            $table->string('cust_name');
            $table->string('cust_email');
            $table->string('card_num');
            $table->unsignedSmallInteger('card_exp_month');
            $table->unsignedSmallInteger('card_exp_year');
            $table->string('property_type');
            $table->unsignedBigInteger('property_id');
            $table->string('price_currency');
            $table->decimal('paid_amount', 10, 2);
            $table->decimal('unit_price', 10, 2);
            $table->string('txn_id');
            $table->string('payment_status');
            $table->timestamp('created')->nullable();
            $table->timestamp('modified')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
