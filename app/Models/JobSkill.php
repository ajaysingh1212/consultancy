<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSkill extends Model
{
    protected $fillable = [
        'job_id',
        'skill_id',
        'is_mandatory',
        'experience_required',   // in years
        'weight',                // scoring weight
    ];

    protected $casts = [
        'job_id'             => 'integer',
        'skill_id'           => 'integer',
        'is_mandatory'       => 'boolean',
        'experience_required'=> 'integer',
        'weight'             => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeMandatory($query)
    {
        return $query->where('is_mandatory', true);
    }

    public function scopeOptional($query)
    {
        return $query->where('is_mandatory', false);
    }
}
