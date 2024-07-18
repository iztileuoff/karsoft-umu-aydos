<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'tariff_id',
        'payment_id',
        'amount',
        'is_paid',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'tariff_id' => 'integer',
        'payment_id' => 'integer',
        'amount' => 'integer',
        'is_paid' => 'boolean',
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

    protected function clickUrl(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => config('app.url').'/pay/click/'.$attributes['id'].'/'.$attributes['amount'],
            set: null
        );
    }

    protected function paymeUrl(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => config('app.url').'/pay/payme/'.$attributes['id'].'/'.($attributes['amount']),
            set: null
        );
    }

    protected function uzumUrl(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => config('app.url').'/uzum-bank/'.$attributes['id'].'/'.($attributes['amount']),
            set: null
        );
    }

    public function scopeSearch(Builder $query, $search): void
    {
        $query->whereHas('user', function (Builder $builder) use ($search) {
            $builder->search($search);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function payment_url(): string
    {
        return match ($this->payment_id) {
            \App\Enums\Payment::Click->value => $this->click_url,
            \App\Enums\Payment::Payme->value => $this->payme_url,
            \App\Enums\Payment::Uzum_bank->value => $this->uzum_url,
        };
    }
}
