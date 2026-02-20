<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visa_applications', function (Blueprint $table) {

            $table->string('process_stage')
                  ->default('medical')
                  ->after('visa_status');

            $table->date('medical_date')->nullable()->after('process_stage');
            $table->date('pcc_date')->nullable()->after('medical_date');
            $table->date('visa_submitted_date')->nullable()->after('pcc_date');
            $table->date('visa_approved_date')->nullable()->after('visa_submitted_date');
            $table->date('ticket_issued_date')->nullable()->after('visa_approved_date');
            $table->date('deployment_date')->nullable()->after('ticket_issued_date');

        });
    }

    public function down(): void
    {
        Schema::table('visa_applications', function (Blueprint $table) {

            $table->dropColumn([
                'process_stage',
                'medical_date',
                'pcc_date',
                'visa_submitted_date',
                'visa_approved_date',
                'ticket_issued_date',
                'deployment_date',
            ]);

        });
    }
};
