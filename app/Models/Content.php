<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Content extends Model
{
    use HasTranslations, HasFactory;

    protected $fillable = [
        'lesson_id',
        'title',
        'body',
        'position',
    ];

    public $translatable = ['title', 'body'];

    protected $casts = [
        'lesson_id' => 'integer',
        'title' => 'string',
        'body' => 'string',
        'position' => 'integer',
    ];

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

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function getUrl(): string
    {
        return config('app.front_url') . '/content/'. $this->id;
    }
}
