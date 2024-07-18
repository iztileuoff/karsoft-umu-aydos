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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function url(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => config('app.url') . "/storage/images/" . $attributes['file_name'],
            set: null
        );
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
