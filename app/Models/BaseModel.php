<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Blameable;

class BaseModel extends BaseModel
{
    use Blameable;
}
