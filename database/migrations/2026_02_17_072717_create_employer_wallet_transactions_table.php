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
        Schema::create('employer_wallet_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employer_id')->constrained()->cascadeOnDelete();

            $table->decimal('amount',12,2);
            $table->string('type'); // credit / debit
            $table->string('purpose')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_method')->nullable();

            $table->decimal('balance_after',12,2)->nullable();

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employer_wallet_transactions');
    }
};
