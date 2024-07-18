<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UpdatePaymentRequest;
use App\Http\Resources\V1\Admin\PaymentResource;
use App\Models\Payment;
use App\Services\Api\V1\Admin\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $payments = Payment::all();

        return response()->success(PaymentResource::collection($payments));
    }
}
