<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    protected $fillable = [
        'file_name',
        'imageable_id',
        'imageable_type',
    ];

    protected $casts = [
        'file_name' => 'string',
        'imageable_id' => 'integer',
        'imageable_type' => 'string',
    ];

    public function url(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => config('app.url') . "/storage/images/" . $attributes['file_name'],
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

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
