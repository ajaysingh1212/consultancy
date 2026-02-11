<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'description',
        'reference_type',
        'reference_id',
        'created_by'
    ];

    public function wallet()
    {
        return $this->belongsTo(CandidateWallet::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

