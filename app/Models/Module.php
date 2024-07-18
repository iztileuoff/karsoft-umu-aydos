<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Module extends Model
{
    use HasTranslations, HasFactory;

    protected $fillable = [
        'title',
        'description',
        'position',
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'position' => 'integer',
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

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function lessons_re_position(): void
    {
        $lessons = $this->lessons;
        $lessons_count = 0;

        foreach ($lessons as $lesson) {
            $lesson->update(['position' => $lessons_count++]);
        }
    }
}
