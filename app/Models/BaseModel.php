<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Blameable;
use App\Scopes\OwnedByUserScope;

class BaseModel extends Model
{
    use Blameable;

    protected static function booted()
    {
        static::addGlobalScope(new OwnedByUserScope);
    }
}
