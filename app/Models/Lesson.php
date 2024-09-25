<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Translatable\HasTranslations;

class Lesson extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'module_id',
        'position',
        'title',
        'lesson_type_id',
        'is_free'
    ];

    public $translatable = ['title'];

    protected $casts = [
        'module_id' => 'integer',
        'position' => 'integer',
        'title' => 'string',
        'lesson_type_id' => 'integer',
        'is_free' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeSearch(Builder $query, $search): void
    {
        $search = mb_strtolower($search, 'UTF-8');

        $query->where(function ($builder) use ($search) {
            $builder->whereRaw('LOWER(JSON_EXTRACT(title, "$.ltn")) LIKE ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(JSON_EXTRACT(title, "$.cyr")) LIKE ?', ["%{$search}%"]);
        });
    }

    public function scopeLessonTypeId(Builder $query, $lesson_type_id): void
    {
        $query->where('lesson_type_id', $lesson_type_id);
    }

    public function lessonType(): BelongsTo
    {
        return $this->belongsTo(LessonType::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class)->orderBy('position', 'asc');
    }

    public function oldestContent(): HasOne
    {
        return $this->hasOne(Content::class)->oldestOfMany();
    }

    public function questions(): MorphMany
    {
        return $this->morphMany(Question::class, 'questionable');
    }

    public function results(): MorphMany
    {
        return $this->morphMany(Result::class, 'resultable');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
