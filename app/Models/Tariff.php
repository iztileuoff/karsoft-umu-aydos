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
    ];

    public $translatable = ['title', 'description'];

    public function createdAt(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => Carbon::parse($attributes['created_at'])->format('Y-m-d H:i:s')
        );
    }

    public function updatedAt(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => Carbon::parse($attributes['updated_at'])->format('Y-m-d H:i:s')
        );
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
