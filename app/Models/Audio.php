<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Audio extends Model
{
    protected $fillable = [
        'file_name',
        'audioable_id',
        'audioable_type',
    ];

    protected $casts = [
        'file_name' => 'string',
        'audioable_id' => 'integer',
        'audioable_type' => 'string',
    ];

    public function url(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => config('app.url') . "/storage/audio/" . $attributes['file_name'],
            set: null
        );
    }

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

    public function audioable(): MorphTo
    {
        return $this->morphTo();
    }
}
