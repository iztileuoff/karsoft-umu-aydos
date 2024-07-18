<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\User\TariffResource;
use App\Models\Tariff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    public function show(Tariff $tariff): JsonResponse
    {
        return response()->success(new TariffResource($tariff));
    }
}
