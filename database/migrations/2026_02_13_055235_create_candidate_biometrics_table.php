<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('candidate_biometrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained()->onDelete('cascade');

            $table->longText('live_photo')->nullable();
            $table->string('photo_status')->default('pending');

            // 10 Fingers
            $table->longText('left_thumb')->nullable();
            $table->string('left_thumb_status')->default('pending');

            $table->longText('left_index')->nullable();
            $table->string('left_index_status')->default('pending');

            $table->longText('left_middle')->nullable();
            $table->string('left_middle_status')->default('pending');

            $table->longText('left_ring')->nullable();
            $table->string('left_ring_status')->default('pending');

            $table->longText('left_little')->nullable();
            $table->string('left_little_status')->default('pending');

            $table->longText('right_thumb')->nullable();
            $table->string('right_thumb_status')->default('pending');

            $table->longText('right_index')->nullable();
            $table->string('right_index_status')->default('pending');

            $table->longText('right_middle')->nullable();
            $table->string('right_middle_status')->default('pending');

            $table->longText('right_ring')->nullable();
            $table->string('right_ring_status')->default('pending');

            $table->longText('right_little')->nullable();
            $table->string('right_little_status')->default('pending');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_biometrics');
    }
};
