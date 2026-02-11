<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentVerificationHistory extends Model
{
    protected $fillable = [
        'document_id',
        'action_by',
        'status',
        'remarks',
    ];

    public function document()
    {
        return $this->belongsTo(CandidateDocument::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'action_by');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
