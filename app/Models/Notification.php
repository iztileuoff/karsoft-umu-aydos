<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Notification extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'description',
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $translatable = ['title', 'description'];

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
}
