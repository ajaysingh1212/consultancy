<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Employer extends Model
{
    protected $fillable = [

        // Basic Info
        'company_name',
        'company_slug',
        'company_email',
        'company_phone',
        'alternate_phone',

        // Branding
        'logo',
        'cover_image',
        'website',
        'linkedin',
        'facebook',
        'twitter',

        // Company Details
        'industry',
        'company_size',
        'founded_year',
        'registration_number',
        'tax_number',
        'gst_number',

        // HR Contact
        'contact_person_name',
        'contact_person_email',
        'contact_person_phone',
        'contact_person_designation',

        // Address
        'address',
        'country',
        'state',
        'city',
        'postal_code',

        // Financial
        'wallet_balance',

        // Status
        'is_verified',
        'is_active',
    ];

    protected $casts = [
        'is_verified'    => 'boolean',
        'is_active'      => 'boolean',
        'wallet_balance' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Boot Method (Auto Slug Generate)
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employer) {
            if (empty($employer->company_slug)) {
                $employer->company_slug =
                    Str::slug($employer->company_name) . '-' . time();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function walletTransactions()
    {
        return $this->hasMany(EmployerWalletTransaction::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor (Dynamic Wallet Balance)
    |--------------------------------------------------------------------------
    */

    public function getCalculatedWalletBalanceAttribute()
    {
        $credit = $this->walletTransactions()
            ->where('type', 'credit')
            ->sum('amount');

        $debit = $this->walletTransactions()
            ->where('type', 'debit')
            ->sum('amount');

        return $credit - $debit;
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
}
