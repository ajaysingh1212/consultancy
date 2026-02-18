<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Job extends Model
{
    protected $fillable = [

        // Foreign
        'employer_id',

        // Basic Info
        'job_title',
        'job_slug',
        'job_reference',

        'job_type',
        'work_mode',
        'experience_level',
        'min_experience',
        'max_experience',

        // Salary
        'salary_min',
        'salary_max',
        'salary_currency',
        'salary_negotiable',

        // Location
        'location',
        'country',

        // Content
        'job_summary',
        'job_description',
        'responsibilities',
        'requirements',
        'benefits',

        'vacancies',
        'application_deadline',

        // Boost / Featured
        'is_featured',
        'is_boosted',
        'boost_expiry',

        // Stats
        'views_count',
        'applications_count',

        // Status
        'is_active',
        'is_approved',
    ];

    protected $casts = [
        'salary_min'          => 'decimal:2',
        'salary_max'          => 'decimal:2',
        'salary_negotiable'   => 'boolean',
        'is_featured'         => 'boolean',
        'is_boosted'          => 'boolean',
        'is_active'           => 'boolean',
        'is_approved'         => 'boolean',
        'boost_expiry'        => 'datetime',
        'application_deadline'=> 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Boot Method (Auto Slug)
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($job) {
            if (empty($job->job_slug)) {
                $job->job_slug = Str::slug($job->job_title) . '-' . time();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Job belongs to Employer
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    // Job has many applications
    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    // Job has many skills
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skills')
            ->withPivot('is_mandatory')
            ->withTimestamps();
    }

    // Job has many boosts
    public function boosts()
    {
        return $this->hasMany(JobBoost::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeBoosted($query)
    {
        return $query->where('is_boosted', true)
                     ->where('boost_expiry', '>=', now());
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function isExpired()
    {
        return $this->application_deadline
            ? $this->application_deadline->isPast()
            : false;
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function incrementApplications()
    {
        $this->increment('applications_count');
    }

    public function checkBoostValidity()
    {
        if ($this->boost_expiry && $this->boost_expiry->isPast()) {
            $this->update(['is_boosted' => false]);
        }
    }
}
