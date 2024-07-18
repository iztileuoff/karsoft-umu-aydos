<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'password',
        'role_id',
        'available_to'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'phone' => 'string',
        'role_id' => 'integer',
        'available_to' => 'datetime',
        'password' => 'hashed',
    ];

    public function password(): Attribute
    {
        return new Attribute(
            get: null,
            set: fn($value) => bcrypt($value)
        );
    }

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

    public function isAdmin(): bool
    {
        return in_array($this->role_id, [\App\Enums\Role::ADMIN->value, \App\Enums\Role::SUPER_ADMIN->value]);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role_id == \App\Enums\Role::SUPER_ADMIN->value;
    }

    public function scopeSearch(Builder $query, $search): void
    {
        $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('phone', 'like', '%' . $search . '%');
    }

    public function scopePhone(Builder $query, $phone): void
    {
        $query->where('phone', $phone);
    }

    public function role(): BelongsTo
    {
        return  $this->belongsTo(Role::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }
}
