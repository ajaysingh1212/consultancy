<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Interview extends Model
{
    protected $fillable = [
        'job_application_id',
        'interview_date',
        'mode',               // online / offline
        'meeting_link',
        'location',
        'interviewer_name',
        'interviewer_email',
        'notes',
        'result',             // pass / fail / pending
    ];

    protected $casts = [
        'interview_date' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Constants (Clean Status Handling)
    |--------------------------------------------------------------------------
    */

    const RESULT_PENDING = 'pending';
    const RESULT_PASS    = 'pass';
    const RESULT_FAIL    = 'fail';

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }

    // Direct access to Job
    public function job()
    {
        return $this->jobApplication->job();
    }

    // Direct access to Candidate
    public function candidate()
    {
        return $this->jobApplication->candidate();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeUpcoming($query)
    {
        return $query->where('interview_date', '>=', now());
    }

    public function scopePast($query)
    {
        return $query->where('interview_date', '<', now());
    }

    public function scopePassed($query)
    {
        return $query->where('result', self::RESULT_PASS);
    }

    public function scopeFailed($query)
    {
        return $query->where('result', self::RESULT_FAIL);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function isUpcoming()
    {
        return $this->interview_date->isFuture();
    }

    public function isToday()
    {
        return $this->interview_date->isToday();
    }

    public function markAsPassed()
    {
        $this->update(['result' => self::RESULT_PASS]);
    }

    public function markAsFailed()
    {
        $this->update(['result' => self::RESULT_FAIL]);
    }
    public function application()
    {
        return $this->belongsTo(
            JobApplication::class,
            'job_application_id'
        );
    }
}
