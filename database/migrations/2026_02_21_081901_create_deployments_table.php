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
        Schema::create('deployments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('candidate_id')->constrained()->cascadeOnDelete();
            $table->foreignId('visa_application_id')->constrained()->cascadeOnDelete();

            $table->string('flight_number')->nullable();
            $table->string('departure_city')->nullable();
            $table->string('arrival_city')->nullable();
            $table->date('departure_date')->nullable();
            $table->time('departure_time')->nullable();

            $table->string('ticket_number')->nullable();
            $table->enum('ticket_status',['pending','booked','issued'])->default('pending');

            $table->string('employer_contact')->nullable();
            $table->string('accommodation_address')->nullable();

            $table->enum('deployment_status',['pending','departed','arrived','completed'])->default('pending');

            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deployments');
    }
};
