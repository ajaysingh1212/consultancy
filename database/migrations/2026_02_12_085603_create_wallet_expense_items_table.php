<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_expense_items', function (Blueprint $table) {

            $table->id();

            // Parent Invoice
            $table->foreignId('wallet_expense_id')
                  ->constrained('wallet_expenses')
                  ->cascadeOnDelete();

            // Expense Category
            $table->foreignId('category_id')
                  ->constrained('expense_categories')
                  ->cascadeOnDelete();

            // Line Item Details
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->decimal('gst_percent', 5, 2)->nullable()->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('row_total', 12, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_expense_items');
    }
};

