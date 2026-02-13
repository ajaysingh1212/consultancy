<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletExpense extends Model
{
    protected $fillable = [
        'wallet_id',
        'invoice_no',
        'expense_date',
        'sub_total',
        'cgst',
        'sgst',
        'total_tax',
        'grand_total',
        'category',
        'remarks',
        'attachment',
        'status',
        'created_by',
        'approved_by',
        'description',
        'amount',
        'gst_percent',
        'tax_amount',
        'row_total'
    ];

    public function wallet()
    {
        return $this->belongsTo(CandidateWallet::class);
    }
}
