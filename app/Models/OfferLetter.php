<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferLetter extends Model
{
    protected $fillable = [
        'job_application_id',
        'offer_file',
        'offered_salary',
        'salary_currency',
        'joining_date',
        'terms_conditions',
        'is_accepted',
        'accepted_at',
        'rejected_at',
    ];

    protected $casts = [
        'offered_salary' => 'decimal:2',
        'joining_date'   => 'date',
        'is_accepted'    => 'boolean',
        'accepted_at'    => 'datetime',
        'rejected_at'    => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }

    public function job()
    {
        return $this->jobApplication->job();
    }

    public function candidate()
    {
        return $this->jobApplication->candidate();
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function markAsAccepted()
    {
        $this->update([
            'is_accepted' => true,
            'accepted_at' => now(),
        ]);

        // Update application status
        $this->jobApplication?->markAsHired();
    }

    public function markAsRejected()
    {
        $this->update([
            'is_accepted' => false,
            'rejected_at' => now(),
        ]);

        $this->jobApplication?->markAsRejected();
    }
}
