<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisaDocument extends Model
{
    use HasFactory;

    protected $fillable = [

        'visa_application_id',
        'candidate_id',

        'document_type',
        'document_number',

        'file_path',
        'file_name',
        'file_size',
        'mime_type',

        'issued_date',
        'expiry_date',

        'verification_status',
        'verified_by',
        'verified_at',

        'remarks',
    ];

    protected $casts = [
        'issued_date'    => 'date',
        'expiry_date'    => 'date',
        'verified_at'    => 'datetime',
    ];

    /* =====================================================
        RELATIONSHIPS
    ===================================================== */

    // Belongs to Visa Application
    public function visaApplication()
    {
        return $this->belongsTo(VisaApplication::class);
    }

    // Direct Candidate Relation (Optional but recommended)
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    // Verified by Admin/User
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /* =====================================================
        SCOPES
    ===================================================== */

    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'verified');
    }

    public function scopePending($query)
    {
        return $query->where('verification_status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('verification_status', 'rejected');
    }

    public function scopeExpiringSoon($query)
    {
        return $query->whereDate('expiry_date', '<=', now()->addDays(30));
    }

    /* =====================================================
        ACCESSORS
    ===================================================== */

    // Check if document expired
    public function getIsExpiredAttribute()
    {
        return $this->expiry_date
            ? $this->expiry_date->isPast()
            : false;
    }

    // Human readable status
    public function getStatusBadgeAttribute()
    {
        return match($this->verification_status) {
            'verified' => 'success',
            'rejected' => 'danger',
            default    => 'warning',
        };
    }

    // File full URL accessor
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}
