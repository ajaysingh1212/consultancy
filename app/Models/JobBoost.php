<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobBoost extends Model
{
    protected $fillable = [
        'job_id',
        'amount',
        'days',
        'expiry_date',
        'is_active',
    ];

    protected $casts = [
        'amount'      => 'decimal:2',
        'days'        => 'integer',
        'expiry_date' => 'datetime',
        'is_active'   => 'boolean',
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

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('expiry_date', '>=', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', now());
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function isExpired()
    {
        return $this->expiry_date->isPast();
    }

    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    /*
    |--------------------------------------------------------------------------
    | Static Boost Creator (With Expiry)
    |--------------------------------------------------------------------------
    */

    public static function createBoost($job, $amount, $days)
    {
        $expiry = now()->addDays($days);

        // Update Job Table
        $job->update([
            'is_boosted' => true,
            'boost_expiry' => $expiry
        ]);

        return self::create([
            'job_id' => $job->id,
            'amount' => $amount,
            'days' => $days,
            'expiry_date' => $expiry,
            'is_active' => true,
        ]);
    }
}
