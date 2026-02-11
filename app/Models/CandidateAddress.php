<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class CandidateAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'type',          // present | permanent
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'status',        // pending | verified | rejected
        'remarks',
        'verified_by',
        'verified_at'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    // Address belongs to Candidate
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    // Address verified by Admin User
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    // Full formatted address
    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->city}, {$this->state}, {$this->country} - {$this->pincode}";
    }

    // Status Badge Class (UI Helper)
    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            'verified' => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
            default    => 'bg-yellow-100 text-yellow-700',
        };
    }

    // Check if verified
    public function isVerified()
    {
        return $this->status === 'verified';
    }
}
