<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerWalletTransaction extends Model
{
    protected $fillable = [
        'employer_id',
        'amount',
        'type',              // credit / debit
        'purpose',           // job_post_fee, job_boost, subscription etc
        'transaction_id',
        'payment_method',
        'balance_after',
    ];

    protected $casts = [
        'amount'        => 'decimal:2',
        'balance_after' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Constants (Clean Coding)
    |--------------------------------------------------------------------------
    */

    const TYPE_CREDIT = 'credit';
    const TYPE_DEBIT  = 'debit';

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeCredit($query)
    {
        return $query->where('type', self::TYPE_CREDIT);
    }

    public function scopeDebit($query)
    {
        return $query->where('type', self::TYPE_DEBIT);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public static function addTransaction($employerId, $amount, $type, $purpose = null, $paymentMethod = null)
    {
        $employer = Employer::findOrFail($employerId);

        // Calculate new balance
        $currentBalance = $employer->calculated_wallet_balance ?? 0;

        $newBalance = $type === self::TYPE_CREDIT
            ? $currentBalance + $amount
            : $currentBalance - $amount;

        return self::create([
            'employer_id'  => $employerId,
            'amount'       => $amount,
            'type'         => $type,
            'purpose'      => $purpose,
            'payment_method' => $paymentMethod,
            'balance_after' => $newBalance,
            'transaction_id' => uniqid('TXN-'),
        ]);
    }
}
