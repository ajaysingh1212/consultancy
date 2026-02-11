<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CandidateWallet;
use App\Models\WalletTransaction;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = CandidateWallet::with('candidate')
                    ->latest()
                    ->paginate(15);

        return view('admin.wallet.index', compact('wallets'));
    }
        // ✅ Specific Candidate Wallet
    public function show($candidateId)
    {
        $candidate = Candidate::with('wallet.transactions.admin')
                    ->findOrFail($candidateId);

        return view('admin.wallet.show', compact('candidate'));
    }
    public function transaction(Request $request, $walletId)
    {
        $wallet = CandidateWallet::findOrFail($walletId);

        $request->validate([
            'type' => 'required|in:credit,debit,refund',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string'
        ]);

        if ($request->type === 'debit' && $wallet->balance < $request->amount) {
            return back()->with('error', 'Insufficient Balance');
        }

        DB::transaction(function () use ($request, $wallet) {

            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => $request->type,
                'amount' => $request->amount,
                'description' => $request->description,
                'created_by' => auth()->id()
            ]);

            // Update Balance
            if ($request->type === 'credit' || $request->type === 'refund') {
                $wallet->increment('balance', $request->amount);
            } else {
                $wallet->decrement('balance', $request->amount);
            }
        });

        return back()->with('success', 'Transaction Successful');
    }
}
