<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisaApplication extends Model
{
    use HasFactory;

    protected $fillable = [

        'candidate_id',
        'job_id',

        'visa_type',
        'country',
        'embassy_name',
        'application_number',

        'submission_date',
        'appointment_date',
        'visa_issue_date',
        'visa_expiry_date',

        'medical_status',
        'immigration_status',
        'visa_status',
        'process_stage',
        'medical_date',
        'pcc_date',
        'visa_submitted_date',
        'visa_approved_date',
        'ticket_issued_date',
        'deployment_date',

        'visa_fee',
        'service_charge',

        'remarks',
    ];

    protected $casts = [
        'submission_date'    => 'date',
        'appointment_date'   => 'date',
        'visa_issue_date'    => 'date',
        'visa_expiry_date'   => 'date',
        'visa_fee'           => 'decimal:2',
        'service_charge'     => 'decimal:2',
    ];

    /* =====================================================
        RELATIONSHIPS
    ===================================================== */

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function deployment()
    {
        return $this->hasOne(Deployment::class);
    }

    public function documents()
    {
        return $this->hasMany(VisaDocument::class);
    }

    /* =====================================================
        SCOPES
    ===================================================== */

    public function scopeApproved($query)
    {
        return $query->where('visa_status', 'approved');
    }

    public function scopeProcessing($query)
    {
        return $query->where('visa_status', 'processing');
    }

    public function scopeRejected($query)
    {
        return $query->where('visa_status', 'rejected');
    }

    /* =====================================================
        ACCESSORS
    ===================================================== */

    public function getTotalCostAttribute()
    {
        return ($this->visa_fee ?? 0) + ($this->service_charge ?? 0);
    }

    public function getIsExpiredAttribute()
    {
        return $this->visa_expiry_date
            ? $this->visa_expiry_date->isPast()
            : false;
    }
}
