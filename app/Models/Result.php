<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Result extends Model
{
    protected $fillable = [
        'user_id',
        'resultable_id',
        'resultable_type',
        'started_at',
        'complated_at',
        'count_questions',
        'count_correct_questions',
        'count_incorrect_questions',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'resultable_id' => 'integer',
        'resultable_type' => 'string',
        'started_at' => 'datetime',
        'complated_at' => 'datetime',
        'count_questions' => 'integer',
        'count_correct_questions' => 'integer',
        'count_incorrect_questions' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resultable(): MorphTo
    {
        return $this->morphTo();
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class)->withPivot(['is_answered']);
    }

    public function historyQuestions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class)
//            ->wherePivot('is_answered', 1)
            ->withPivot(['options', 'drags', 'answer_text','is_answered', 'is_correct']);
    }
}
