<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Tariff extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'description',
        'month',
        'price',
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'month' => 'integer',
        'price' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $translatable = ['title', 'description'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
