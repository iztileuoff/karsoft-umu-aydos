<?php

namespace App\Services\Api\V1\Admin;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderService
{
    public function index(Request $request): array
    {
        $orders = Order::when($request->search, function ($query) use ($request) {
            $query->search($request->search);
        })
            ->orderBy('id', 'desc')
            ->with([
                'user:id,name,phone',
                'tariff:id,title,month',
                'payment:id,title'
            ]);

        $result = $request->limit ? $orders->paginate($request->limit) : $orders->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }
}
