<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('wallet_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained('candidate_wallets')->cascadeOnDelete();
            $table->string('invoice_no')->unique();
            $table->date('expense_date');

            $table->decimal('sub_total', 15,2)->default(0);
            $table->decimal('cgst', 15,2)->default(0);
            $table->decimal('sgst', 15,2)->default(0);
            $table->decimal('total_tax', 15,2)->default(0);
            $table->decimal('grand_total', 15,2)->default(0);

            $table->string('category')->nullable();
            $table->text('remarks')->nullable();
            $table->string('attachment')->nullable();

            $table->enum('status',['pending','approved','rejected'])->default('pending');

            $table->foreignId('created_by')->nullable();
            $table->foreignId('approved_by')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_expenses');
    }
};
