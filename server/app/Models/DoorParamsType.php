<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DoorParam;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DoorParamsType extends Model
{
    use HasFactory;
    protected $type = 'string';

    public function door_params(): HasMany
    {
        return $this->hasMany(DoorParam::class);
    }
}