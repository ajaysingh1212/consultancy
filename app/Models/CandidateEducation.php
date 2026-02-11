<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateEducation extends Model
{
    protected $table = 'candidate_educations'; // ✅ FIX
    protected $fillable = [
        'candidate_id','level','board_university',
        'institution','passing_year','marks','certificate','verification_status','roll_no','roll_code','status','remarks',
        'verified_by','	verified_at'
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            'verified' => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
            default    => 'bg-yellow-100 text-yellow-700',
        };
    }

    public function isVerified()
    {
        return $this->status === 'verified';
    }
}

