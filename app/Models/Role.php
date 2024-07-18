<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
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

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
