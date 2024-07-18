<?php

namespace App\Services\Api\V1\User;

use App\Models\Order;
use App\Models\Tariff;
use App\Models\User;

class OrderService
{
    public function store(array $validated, Tariff $tariff, User $user): string
    {
        $order = Order::firstOrCreate([
            'user_id' => $user->id,
            'tariff_id' => $tariff->id,
            'is_paid' => false,
        ], [
            'amount' => $tariff->price,
            'payment_id' => $validated['payment_id']
        ]);

        $order->update([
            'amount' => $tariff->price,
            'payment_id' => $validated['payment_id']
        ]);

        return $order->payment_url();
    }
}
