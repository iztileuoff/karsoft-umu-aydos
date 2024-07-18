<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Option extends Model
{
    protected $fillable = [
        'title',
        'question_id',
        'drag_text',
        'is_correct',
        'position',
    ];

    protected $casts = [
        'title' => 'string',
        'question_id' => 'integer',
        'drag_text' => 'string',
        'is_correct' => 'boolean',
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

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
