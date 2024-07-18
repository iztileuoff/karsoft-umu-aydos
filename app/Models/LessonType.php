<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LessonType extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'name' => 'string'
    ];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
}
