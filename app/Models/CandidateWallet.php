<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateWallet extends Model
{
    protected $fillable = ['candidate_id', 'balance','wallet_uid'];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class, 'wallet_id');
    }

    public function calculateBalance()
    {
        $credit = $this->transactions()->whereIn('type', ['credit','refund'])->sum('amount');
        $debit = $this->transactions()->where('type', 'debit')->sum('amount');

        return $credit - $debit;
    }
}

