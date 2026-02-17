<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateSkill extends Model
{
    protected $fillable = [
        'candidate_id',
        'skill_id',
        'proficiency',       // 1-5 level
        'experience_years',  // experience in years
    ];

    protected $casts = [
        'proficiency'      => 'integer',
        'experience_years' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Belongs to Candidate
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    // Belongs to Skill
    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeExpert($query)
    {
        return $query->where('proficiency', 5);
    }

    public function scopeExperienced($query, $years = 3)
    {
        return $query->where('experience_years', '>=', $years);
    }
}
