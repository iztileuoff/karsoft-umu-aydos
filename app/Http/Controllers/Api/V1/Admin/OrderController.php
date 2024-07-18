<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\OrderResource;
use App\Models\Order;
use App\Services\Api\V1\Admin\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(public OrderService $service)
    {
    }

    public function index(Request $request)
    {
        [$orders, $total] = $this->service->index($request);

        return response()->paginate(OrderResource::collection($orders), $total);
    }

    public function show(Order $order): JsonResponse
    {
        return response()->success(new OrderResource($order));
    }
}
