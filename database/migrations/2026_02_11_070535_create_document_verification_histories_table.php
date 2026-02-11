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
        Schema::create('document_verification_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('candidate_documents')->cascadeOnDelete();
            $table->foreignId('action_by')->nullable()->constrained('users');
            $table->string('status'); // verified | rejected
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_verification_histories');
    }
};
