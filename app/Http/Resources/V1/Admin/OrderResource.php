<?php

namespace App\Http\Resources\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Order */
class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'user_phone' => $this->user->phone,
            'tariff_id' => $this->tariff_id,
            'tariff_title' => $this->tariff->getTranslations('title'),
            'tariff_month' => $this->tariff->month,
            'payment_id' => $this->payment_id,
            'payment_title' => $this->payment->title,
            'amount' => $this->amount,
            'is_paid' => $this->is_paid,
            'payment_url' => $this->when(! $request->routeIs('admin.*'), $this->payment_url()),
            'created_at' => $this->when($request->routeIs('admin.*'), $this->created_at?->format('Y-m-d H:i:s')),
            'updated_at' => $this->when($request->routeIs('admin.*'), $this->updated_at?->format('Y-m-d H:i:s')),
        ];
    }
}
