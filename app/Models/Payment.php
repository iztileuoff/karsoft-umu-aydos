<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    protected $fillable = [
        'title',
    ];

    protected $casts = [
        'title' => 'string',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
