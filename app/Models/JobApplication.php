<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [

        'job_id',
        'candidate_id',

        'resume',
        'cover_letter',
        'portfolio_link',

        'status', // applied, shortlisted, interview, offered, rejected, hired

        'score',
        'skill_match_percentage',

        'applied_at',
        'shortlisted_at',
        'rejected_at',
        'hired_at',
    ];

    protected $casts = [
        'score' => 'integer',
        'skill_match_percentage' => 'decimal:2',
        'applied_at' => 'datetime',
        'shortlisted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'hired_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Constants (Clean Status Handling)
    |--------------------------------------------------------------------------
    */

    const STATUS_APPLIED     = 'applied';
    const STATUS_SHORTLISTED = 'shortlisted';
    const STATUS_INTERVIEW   = 'interview';
    const STATUS_OFFERED     = 'offered';
    const STATUS_REJECTED    = 'rejected';
    const STATUS_HIRED       = 'hired';

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function interview()
    {
        return $this->hasOne(Interview::class);
    }

    public function offerLetter()
    {
        return $this->hasOne(OfferLetter::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeApplied($query)
    {
        return $query->where('status', self::STATUS_APPLIED);
    }

    public function scopeShortlisted($query)
    {
        return $query->where('status', self::STATUS_SHORTLISTED);
    }

    public function scopeHired($query)
    {
        return $query->where('status', self::STATUS_HIRED);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods (Status Updates)
    |--------------------------------------------------------------------------
    */

    public function markAsShortlisted()
    {
        $this->update([
            'status' => self::STATUS_SHORTLISTED,
            'shortlisted_at' => now(),
        ]);
    }

    public function markAsInterview()
    {
        $this->update([
            'status' => self::STATUS_INTERVIEW,
        ]);
    }

    public function markAsOffered()
    {
        $this->update([
            'status' => self::STATUS_OFFERED,
        ]);
    }

    public function markAsRejected()
    {
        $this->update([
            'status' => self::STATUS_REJECTED,
            'rejected_at' => now(),
        ]);
    }

    public function markAsHired()
    {
        $this->update([
            'status' => self::STATUS_HIRED,
            'hired_at' => now(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Skill Matching Logic
    |--------------------------------------------------------------------------
    */

    public function calculateSkillMatch()
    {
        $jobSkills = $this->job->skills;
        $candidateSkills = $this->candidate->skills;

        $totalWeight = 0;
        $earnedWeight = 0;
        $mandatoryMissing = false;

        foreach ($jobSkills as $skill) {

            $pivot = $skill->pivot;
            $totalWeight += $pivot->weight ?? 1;

            $candidateSkill = $candidateSkills->firstWhere('id', $skill->id);

            if ($pivot->is_mandatory && !$candidateSkill) {
                $mandatoryMissing = true;
            }

            if ($candidateSkill) {
                $earnedWeight += $pivot->weight ?? 1;
            }
        }

        $percentage = $totalWeight > 0
            ? round(($earnedWeight / $totalWeight) * 100)
            : 0;

        if ($mandatoryMissing) {
            $this->update([
                'status' => self::STATUS_REJECTED,
                'skill_match_percentage' => 0,
                'score' => 0,
                'rejected_at' => now(),
            ]);
            return;
        }

        $this->update([
            'skill_match_percentage' => $percentage,
            'score' => $percentage,
        ]);
    }

}
