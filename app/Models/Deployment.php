<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deployment extends Model
{
    use HasFactory;

    protected $fillable = [

        'candidate_id',
        'visa_application_id',
        'job_id',

        // Travel Details
        'flight_number',
        'departure_city',
        'arrival_city',
        'departure_date',
        'departure_time',
        'arrival_date',
        'arrival_time',

        // Ticket
        'ticket_number',
        'ticket_status',

        // Employer / Location
        'employer_name',
        'employer_contact',
        'accommodation_address',

        // Deployment Tracking
        'deployment_status',
        'joined_date',
        'contract_start_date',
        'contract_end_date',

        'remarks',
    ];

    protected $casts = [
        'departure_date'      => 'date',
        'arrival_date'        => 'date',
        'joined_date'         => 'date',
        'contract_start_date' => 'date',
        'contract_end_date'   => 'date',
    ];

    /* =====================================================
        RELATIONSHIPS
    ===================================================== */

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function visaApplication()
    {
        return $this->belongsTo(VisaApplication::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    /* =====================================================
        SCOPES
    ===================================================== */

    public function scopePending($query)
    {
        return $query->where('deployment_status', 'pending');
    }

    public function scopeDeparted($query)
    {
        return $query->where('deployment_status', 'departed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('deployment_status', 'completed');
    }

    /* =====================================================
        ACCESSORS
    ===================================================== */

    public function getIsActiveAttribute()
    {
        return $this->deployment_status !== 'completed';
    }

    public function getTravelRouteAttribute()
    {
        return $this->departure_city . ' → ' . $this->arrival_city;
    }
}
