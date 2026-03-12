<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Blameable;
use App\Models\User;
use App\Scopes\OwnedByUserScope;

class BaseModel extends Model
{
    use Blameable;

    protected $with = ['creator']; // ⭐ auto eager loading

    protected static function booted()
    {
        static::addGlobalScope(new OwnedByUserScope);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
