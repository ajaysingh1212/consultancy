<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CandidateWallet;
use App\Models\ExpenseCategory;
use App\Models\WalletExpense;
use App\Models\WalletExpenseItem;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Psy\Util\Str;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = CandidateWallet::with([
            'candidate',
            'transactions' => function ($q) {
                $q->where('reference_type', 'wallet_deposit');
            }
        ])->latest()->get();

        return view('admin.wallet.index', compact('wallets'));
    }


    public function show($candidateId)
    {
        $candidate = Candidate::with('wallet.transactions.admin')
                    ->findOrFail($candidateId);

        return view('admin.wallet.show', compact('candidate'));
    }

    // ================= ADD MONEY =================
    public function addMoney(Request $request, $walletId)
    {
        $wallet = CandidateWallet::findOrFail($walletId);

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string'
        ]);

        WalletTransaction::create([
            'wallet_id'        => $wallet->id,
            'type'             => 'credit',
            'transaction_type' => 'deposit',
            'amount'           => $request->amount,
            'description'      => $request->description,
            'reference_type'   => 'wallet_deposit',
            'reference_id'     => mt_rand(10000000000, 99999999999),
            'status'           => 'pending',
            'created_by'       => auth()->id()
        ]);

        return back()->with('success','Deposit Request Submitted (Pending)');
    }

    // ================= APPROVE =================
    public function approve($transactionId)
    {
        $transaction = WalletTransaction::with('wallet')
                        ->findOrFail($transactionId);

        if ($transaction->status !== 'pending') {
            return back();
        }

        DB::transaction(function () use ($transaction) {

            $transaction->update([
                'status' => 'approved'
            ]);

            $transaction->wallet->increment('balance', $transaction->amount);
        });

        return back()->with('success','Deposit Approved & Balance Updated');
    }

    // ================= EXPENSE PAGE =================

    public function expensePage()
    {
        $wallets = CandidateWallet::with('candidate')->get();
        $categories = ExpenseCategory::where('status',1)->get();

        return view('admin.wallet.expense', compact('wallets','categories'));
    }

    // ================= STORE EXPENSE =================


public function storeExpense(Request $request)
{
    $request->validate([
        'wallet_id'        => 'required|exists:candidate_wallets,id',
        'invoice_no'       => 'required|string',
        'expense_date'     => 'required|date',

        'category'         => 'required|array',
        'category.*'       => 'required|exists:expense_categories,id',

        'description'      => 'required|array',
        'description.*'    => 'required|string',

        'amount'           => 'required|array',
        'amount.*'         => 'required|numeric|min:0',

        'gst_percent'      => 'nullable|array',
        'gst_percent.*'    => 'nullable|numeric|min:0',

        'tax_amount'       => 'nullable|array',
        'tax_amount.*'     => 'nullable|numeric|min:0',

        'row_total'        => 'required|array',
        'row_total.*'      => 'required|numeric|min:0',

        'sub_total'        => 'required|numeric',
        'total_tax'        => 'required|numeric',
        'grand_total'      => 'required|numeric',
    ]);

    DB::beginTransaction();

    try {

        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')
                ->store('wallet-expenses', 'public');
        }

        // ✅ Only Summary Data
        $expense = WalletExpense::create([
            'wallet_id'    => $request->wallet_id,
            'invoice_no'   => $request->invoice_no,
            'expense_date' => $request->expense_date,
            'sub_total'    => $request->sub_total,
            'cgst'         => $request->cgst ?? 0,
            'sgst'         => $request->sgst ?? 0,
            'total_tax'    => $request->total_tax,
            'grand_total'  => $request->grand_total,
            'remarks'      => $request->remarks,
            'attachment'   => $attachmentPath,
            'status'       => 'pending',
            'created_by'   => auth()->id()
        ]);

        // ✅ Line Items
        foreach ($request->category as $index => $categoryId) {

            WalletExpenseItem::create([
                'wallet_expense_id' => $expense->id,
                'category_id'       => $categoryId,
                'description'       => $request->description[$index],
                'amount'            => $request->amount[$index],
                'gst_percent'       => $request->gst_percent[$index] ?? 0,
                'tax_amount'        => $request->tax_amount[$index] ?? 0,
                'row_total'         => $request->row_total[$index],
            ]);
        }

        DB::commit();

        return redirect()
            ->route('admin.wallets.expense.index')
            ->with('success','Expense submitted for approval.');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());
    }
}


public function approveExpense($id)
{
    $expense = WalletExpense::with('wallet')->findOrFail($id);

    // Already approved check
    if ($expense->status !== 'pending') {
        return back()->with('error','Expense already processed.');
    }

    $wallet = $expense->wallet;

    // ✅ Wallet Status Check
    if ($wallet->status !== 'active') {
        return back()->with('error','Wallet is not active. Approval not allowed.');
    }

    // ✅ Balance Check
    if ($wallet->balance < $expense->grand_total) {
        return back()->with('error','Insufficient wallet balance.');
    }

    DB::transaction(function () use ($expense, $wallet) {

        // Deduct from candidate_wallets table
        $wallet->decrement('balance', $expense->grand_total);

        // Update Expense
        $expense->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        // Create ledger transaction
        WalletTransaction::create([
            'wallet_id'        => $wallet->id,
            'type'             => 'debit',
            'transaction_type' => 'expense',
            'amount'           => $expense->grand_total,
            'reference_type'   => 'wallet_expense',
            'reference_id'     => $expense->invoice_no,
            'status'           => 'approved',
            'created_by'       => auth()->id()
        ]);
    });

    return back()->with('success','Expense approved & wallet balance deducted.');
}




    public function transactions($walletId)
    {
        $wallet = CandidateWallet::with([
            'candidate',
            'transactions.admin'
        ])->findOrFail($walletId);

        $transactions = $wallet->transactions()
            ->latest()
            ->paginate(20);

        return view('admin.wallet.transactions', compact('wallet','transactions'));
    }
    public function filterTransactions($walletId, $status)
    {
        $wallet = CandidateWallet::findOrFail($walletId);

        $transactions = $wallet->transactions()
            ->where('reference_type','wallet_deposit')
            ->where('status',$status)
            ->latest()
            ->get();

        return response()->json($transactions);
    }

}
