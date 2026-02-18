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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employer_id')->constrained()->cascadeOnDelete();

            $table->string('job_title');
            $table->string('job_slug')->unique();
            $table->string('job_reference')->nullable();

            $table->string('job_type'); // Full-time, Part-time, Internship
            $table->string('work_mode')->default('onsite'); // onsite, remote, hybrid
            $table->string('experience_level')->nullable();
            $table->integer('min_experience')->nullable();
            $table->integer('max_experience')->nullable();

            $table->decimal('salary_min',12,2)->nullable();
            $table->decimal('salary_max',12,2)->nullable();
            $table->string('salary_currency')->default('INR');
            $table->boolean('salary_negotiable')->default(false);

            $table->string('location');
            $table->string('country')->nullable();

            $table->text('job_summary')->nullable();
            $table->longText('job_description');
            $table->longText('responsibilities')->nullable();
            $table->longText('requirements')->nullable();
            $table->longText('benefits')->nullable();

            $table->integer('vacancies')->default(1);
            $table->date('application_deadline')->nullable();

            // Boost & Featured
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_boosted')->default(false);
            $table->dateTime('boost_expiry')->nullable();

            $table->integer('views_count')->default(0);
            $table->integer('applications_count')->default(0);

            $table->boolean('is_active')->default(true);
            $table->boolean('is_approved')->default(false);

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
