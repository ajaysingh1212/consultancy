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
        Schema::create('visa_documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('visa_application_id')->constrained()->cascadeOnDelete();

            $table->string('document_type');
            $table->string('file_path');
            $table->date('expiry_date')->nullable();

            $table->enum('verification_status',['pending','verified','rejected'])->default('pending');

            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_documents');
    }
};
