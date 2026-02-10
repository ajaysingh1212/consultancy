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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('father_name')->nullable();
            $table->date('dob');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('mobile')->unique();
            $table->string('email')->nullable();
            $table->string('nationality');
            $table->string('passport_number')->unique();
            $table->date('passport_expiry');

            $table->enum('kyc_status',['pending','partial','verified','rejected'])->default('pending');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
