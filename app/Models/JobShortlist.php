<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobShortlist extends Model
{
    protected $fillable = [
        'job_id',
        'candidate_id',
        'job_application_id',
        'notes',
        'added_by', // admin or employer user id
    ];

    protected $casts = [
        'job_id' => 'integer',
        'candidate_id' => 'integer',
        'job_application_id' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Shortlist belongs to Job
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    // Shortlist belongs to Candidate
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    // Optional: Link to Job Application
    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public static function addToShortlist($jobApplication)
    {
        // Prevent duplicate shortlist
        if (self::where('job_application_id', $jobApplication->id)->exists()) {
            return false;
        }

        // Update application status
        $jobApplication->markAsShortlisted();

        return self::create([
            'job_id' => $jobApplication->job_id,
            'candidate_id' => $jobApplication->candidate_id,
            'job_application_id' => $jobApplication->id,
        ]);
    }

    public function removeFromShortlist()
    {
        $this->jobApplication?->update([
            'status' => JobApplication::STATUS_APPLIED
        ]);

        $this->delete();
    }
}
