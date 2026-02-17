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
    Schema::table('candidate_skills', function (Blueprint $table) {
        $table->string('proficiency')->change();
    });
}

public function down()
{
    Schema::table('candidate_skills', function (Blueprint $table) {
        $table->integer('proficiency')->change();
    });
}
};
