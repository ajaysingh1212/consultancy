<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    ];

    /**
     * Relation: Address belongs to Candidate
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    /**
     * Helper: Full formatted address
     */
    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->city}, {$this->state}, {$this->country} - {$this->pincode}";
    }
}
