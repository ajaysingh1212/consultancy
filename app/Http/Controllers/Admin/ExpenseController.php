<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletExpense;
use App\Models\CandidateWallet;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = WalletExpense::with([
                'wallet.candidate',
                'items.category'
            ])
            ->latest()
            ->paginate(10);

        return view('admin.expense.index', compact('expenses'));
    }


    public function create()
    {
        $wallets = CandidateWallet::with('candidate')->get();
        $categories = ExpenseCategory::where('status',1)->get();

        return view('admin.expense.create', compact('wallets','categories'));
    }

    public function store(Request $request)
    {
        WalletExpense::create($request->all());

        return redirect()->route('admin.expenses.index')
            ->with('success','Expense Created');
    }

    public function show($id)
    {
        $expense = WalletExpense::with([
            'wallet.candidate.presentAddress',
            'wallet.candidate.permanentAddress',
            'items.category'
        ])->findOrFail($id);

        return view('admin.expense.show', compact('expense'));
    }

    public function edit(WalletExpense $expense)
    {
        return view('admin.expense.edit', compact('expense'));
    }

    public function update(Request $request, WalletExpense $expense)
    {
        $expense->update($request->all());
        return redirect()->route('admin.expenses.index');
    }

    public function destroy(WalletExpense $expense)
    {
        $expense->delete();
        return back();
    }
}
