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
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Translatable\HasTranslations;

class Question extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'question_type_id',
        'questionable_id',
        'questionable_type',
        'answer_explanation',
    ];

    protected $casts = [
        'title' => 'string',
        'question_type_id' => 'integer',
        'questionable_id' => 'integer',
        'questionable_type' => 'string',
        'answer_explanation' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $translatable = ['title', 'answer_explanation'];

    public function scopeSearch(Builder $query, $search): void
    {
        $search = mb_strtolower($search, 'UTF-8');

        $query->where(function ($builder) use ($search) {
            $builder->whereRaw('LOWER(JSON_EXTRACT(title, "$.ltn")) LIKE ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(JSON_EXTRACT(title, "$.cyr")) LIKE ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(JSON_EXTRACT(answer_explanation, "$.ltn")) LIKE ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(JSON_EXTRACT(answer_explanation, "$.cyr")) LIKE ?', ["%{$search}%"]);
        });
    }

    public function questionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class)->orderBy('position', 'asc');
    }

    public function drags(): HasMany
    {
        return $this->hasMany(Option::class)->select(['drag_text', 'question_id'])->orderBy('position', 'asc');
    }

    public function randomOptions(): HasMany
    {
        return $this->hasMany(Option::class)->inRandomOrder();
    }

    public function questionType(): BelongsTo
    {
        return $this->belongsTo(QuestionType::class);
    }

    public function options_re_position(): void
    {
        $options = $this->options;
        $options_count = 0;

        foreach ($options as $option) {
            $option->update(['position' => $options_count]);

            $options_count++;
        }
    }
}
