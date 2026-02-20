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
        Schema::create('visa_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('candidate_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_id')->nullable()->constrained()->nullOnDelete();

            $table->string('visa_type');
            $table->string('country');
            $table->string('embassy_name')->nullable();
            $table->string('application_number')->nullable();
            $table->date('submission_date')->nullable();
            $table->date('appointment_date')->nullable();
            $table->date('visa_issue_date')->nullable();
            $table->date('visa_expiry_date')->nullable();

            $table->enum('medical_status',['pending','fit','unfit'])->default('pending');
            $table->enum('immigration_status',['pending','approved','rejected'])->default('pending');
            $table->enum('visa_status',['draft','submitted','processing','approved','rejected'])->default('draft');

            $table->decimal('visa_fee',10,2)->nullable();
            $table->decimal('service_charge',10,2)->nullable();

            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_applications');
    }
};
