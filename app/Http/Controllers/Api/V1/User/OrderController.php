<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreOrderRequest;
use App\Models\Tariff;
use App\Services\Api\V1\User\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(public OrderService $service)
    {
    }

    public function store(StoreOrderRequest $request, Tariff $tariff): JsonResponse
    {
        $payment_url = $this->service->store($request->validated(), $tariff, $request->user());

        return response()->success($payment_url);
    }
}
