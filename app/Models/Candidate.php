<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Models\CandidateWallet;

class Candidate extends Model
{
    use Notifiable;

    protected $fillable = [
        'full_name',
        'father_name',
        'email',
        'dob',
        'gender',
        'marital_status',
        'mobile',
        'email',
        'nationality',
        'passport_number',
        'passport_expiry',
        'kyc_status',
        'aadhaar_no',
        'pan_no',
        'bank_name',
        'account_no',
        'ifsc'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function addresses()
    {
        return $this->hasMany(CandidateAddress::class);
    }
    // Only verified present address
    public function presentAddress()
    {
        return $this->hasOne(CandidateAddress::class)
            ->where('type', 'present')
            ->where('status', 'verified');
    }

    // Only verified permanent address
    public function permanentAddress()
    {
        return $this->hasOne(CandidateAddress::class)
            ->where('type', 'permanent')
            ->where('status', 'verified');
    }
    public function educations()
    {
        return $this->hasMany(CandidateEducation::class);
    }

    public function documents()
    {
        return $this->hasMany(CandidateDocument::class);
    }

    public function wallet()
    {
        return $this->hasOne(CandidateWallet::class);
    }

    /*
    |--------------------------------------------------------------------------
    | KYC Completion Accessor
    |--------------------------------------------------------------------------
    */

    public function getKycCompletionAttribute()
    {
        $total = 5;
        $score = 0;

        if ($this->addresses()->exists()) $score++;
        if ($this->educations()->exists()) $score++;
        if ($this->documents()->exists()) $score++;
        if (!empty($this->aadhaar_no)) $score++;
        if (!empty($this->pan_no)) $score++;

        return round(($score / $total) * 100);
    }

    /*
    |--------------------------------------------------------------------------
    | Boot Method - Auto Wallet Create with UID
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::created(function ($candidate) {

            $candidate->wallet()->create([
                'wallet_uid' => self::generateWalletUID(),
                'balance'    => 0
            ]);

        });
    }

    /*
    |--------------------------------------------------------------------------
    | Wallet UID Generator (4 Letters + 4 Digits)
    |--------------------------------------------------------------------------
    */

    private static function generateWalletUID()
    {
        do {
            $letters = strtoupper(Str::random(4));   // ABCD
            $numbers = rand(1000, 9999);             // 4821

            $uid = $letters . $numbers;

        } while (CandidateWallet::where('wallet_uid', $uid)->exists());

        return $uid;
    }
    public function biometric()
    {
        return $this->hasOne(CandidateBiometric::class);
    }


    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'candidate_skills')
            ->withPivot('proficiency', 'experience_years')
            ->withTimestamps();
    }
    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
