<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Translatable\HasTranslations;

class Quiz extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'description',
    ];

    public $translatable = ['title', 'description'];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeSearch(Builder $query, $search): void
    {
        $search = mb_strtolower($search, 'UTF-8');

        $query->where(function ($builder) use ($search) {
            $builder->whereRaw('LOWER(JSON_EXTRACT(title, "$.ltn")) LIKE ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(JSON_EXTRACT(title, "$.cyr")) LIKE ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(JSON_EXTRACT(description, "$.ltn")) LIKE ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(JSON_EXTRACT(description, "$.cyr")) LIKE ?', ["%{$search}%"]);
        });
    }

    public function questions(): MorphMany
    {
        return $this->morphMany(Question::class, 'questionable');
    }

    public function results(): MorphMany
    {
        return $this->morphMany(Result::class, 'resultable');
    }
}
