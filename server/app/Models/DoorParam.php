<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DoorParamsType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoorParam extends Model
{
    use HasFactory;

    protected $title = 'string';

    protected $value = 'string';
    protected $price = 'float';

    protected $casts = ['price' => 'float'];
    public function door_params_type(): BelongsTo
    {
        return $this->belongsTo(DoorParamsType::class);
    }
}