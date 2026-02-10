<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateEducation extends Model
{
    protected $table = 'candidate_educations'; // ✅ FIX
    protected $fillable = [
        'candidate_id','level','board_university',
        'institution','passing_year','marks','certificate','verification_status','roll_no','roll_code'
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}

