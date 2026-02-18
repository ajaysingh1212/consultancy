<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateBiometric extends Model
{
    use HasFactory;

    protected $fillable = [

        'candidate_id',

        // Live Photo
        'live_photo',
        'photo_status',

        // Left Hand
        'left_thumb',
        'left_thumb_status',

        'left_index',
        'left_index_status',

        'left_middle',
        'left_middle_status',

        'left_ring',
        'left_ring_status',

        'left_little',
        'left_little_status',

        // Right Hand
        'right_thumb',
        'right_thumb_status',

        'right_index',
        'right_index_status',

        'right_middle',
        'right_middle_status',

        'right_ring',
        'right_ring_status',

        'right_little',
        'right_little_status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
