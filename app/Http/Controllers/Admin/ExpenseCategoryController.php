<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::latest()->paginate(10);
        return view('admin.expense-category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.expense-category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:expense_categories,name'
        ]);

        ExpenseCategory::create([
            'name' => $request->name,
            'status' => $request->status ?? 1
        ]);

        return redirect()->route('admin.expense.categories.index')
            ->with('success','Category Created');
    }

    public function show(ExpenseCategory $expenseCategory)
    {
        return view('admin.expense-category.show', compact('expenseCategory'));
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        return view('admin.expense-category.edit', compact('expenseCategory'));
    }

    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $expenseCategory->update($request->all());

        return redirect()->route('admin.expense.categories.index')
            ->with('success','Category Updated');
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();

        return back()->with('success','Category Deleted');
    }
}
