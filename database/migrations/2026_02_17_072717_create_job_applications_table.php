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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
            $table->foreignId('candidate_id')->constrained()->cascadeOnDelete();

            $table->string('resume');
            $table->text('cover_letter')->nullable();
            $table->string('portfolio_link')->nullable();

            $table->string('status')->default('applied');
            // applied, shortlisted, interview, offered, rejected, hired

            $table->integer('score')->default(0);
            $table->decimal('skill_match_percentage',5,2)->default(0);

            $table->dateTime('applied_at')->nullable();
            $table->dateTime('shortlisted_at')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->dateTime('hired_at')->nullable();

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
