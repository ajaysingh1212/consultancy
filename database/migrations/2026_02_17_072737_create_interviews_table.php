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
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_application_id')->constrained()->cascadeOnDelete();

            $table->dateTime('interview_date');
            $table->string('mode'); // online/offline
            $table->string('meeting_link')->nullable();
            $table->string('location')->nullable();

            $table->string('interviewer_name')->nullable();
            $table->string('interviewer_email')->nullable();

            $table->text('notes')->nullable();
            $table->string('result')->nullable(); // pass/fail

            $table->timestamps();
        });
;

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
