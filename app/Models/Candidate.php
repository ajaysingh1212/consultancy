<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'full_name','father_name','dob','gender','marital_status',
        'mobile','email','nationality','passport_number','passport_expiry','kyc_status','aadhaar_no','pan_no','bank_name','account_no','ifsc'
    ];

    public function addresses()
    {
        return $this->hasMany(CandidateAddress::class);
    }

    public function educations()
    {
        return $this->hasMany(CandidateEducation::class);
    }

    public function documents()
    {
        return $this->hasMany(CandidateDocument::class);
    }
    public function getKycCompletionAttribute()
{
    $total = 5;
    $score = 0;

    if ($this->addresses()->exists()) $score++;
    if ($this->educations()->exists()) $score++;
    if ($this->documents()->exists()) $score++;
    if ($this->aadhaar_no ?? false) $score++;
    if ($this->pan_no ?? false) $score++;

    return round(($score / $total) * 100);
}

}

