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
        Schema::create('offer_letters', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_application_id')->constrained()->cascadeOnDelete();

            $table->string('offer_file');
            $table->decimal('offered_salary',12,2);
            $table->string('salary_currency')->default('INR');
            $table->date('joining_date');

            $table->text('terms_conditions')->nullable();
            $table->boolean('is_accepted')->default(false);

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_letters');
    }
};
