<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UpdateTariffRequest;
use App\Http\Resources\V1\Admin\TariffResource;
use App\Models\Tariff;
use App\Services\Api\V1\Admin\TariffService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    public function __construct(public TariffService $service)
    {
    }

    public function index(Request $request)
    {
        [$quizzes, $total] = $this->service->index($request);

        return response()->paginate(TariffResource::collection($quizzes), $total);
    }

    public function show(Tariff $tariff): JsonResponse
    {
        return response()->success(new TariffResource($tariff));
    }

    public function update(UpdateTariffRequest $request, Tariff $tariff): JsonResponse
    {
        $tariff = $this->service->update($request->validated(), $tariff);

        return response()->updated(new TariffResource($tariff));
    }
}
