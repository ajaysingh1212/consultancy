<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletExpenseItem extends Model
{
    protected $fillable = [
        'wallet_expense_id',
        'category_id',
        'description',
        'amount',
        'gst_percent',
        'tax_amount',
        'row_total',
    ];

    public function expense()
    {
        return $this->belongsTo(WalletExpense::class,'wallet_expense_id');
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class,'category_id');
    }
}
