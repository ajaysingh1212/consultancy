<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Boot Method (Auto Slug Generate)
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($skill) {
            if (empty($skill->slug)) {
                $skill->slug = Str::slug($skill->name) . '-' . time();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Skill belongs to many Jobs
    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_skills')
            ->withPivot('is_mandatory', 'experience_required', 'weight')
            ->withTimestamps();
    }

    // Skill belongs to many Candidates
    public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'candidate_skills')
            ->withPivot('proficiency', 'experience_years')
            ->withTimestamps();
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

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function jobsCount()
    {
        return $this->jobs()->count();
    }

    public function candidatesCount()
    {
        return $this->candidates()->count();
    }
}
