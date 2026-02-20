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
        Schema::create('visa_stage_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('visa_application_id')->constrained()->cascadeOnDelete();

            $table->string('stage');
            // medical, pcc, submitted, approved, ticket_issued, deployed

            $table->date('stage_date')->nullable();
            $table->text('remarks')->nullable();

            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_stage_histories');
    }
};
