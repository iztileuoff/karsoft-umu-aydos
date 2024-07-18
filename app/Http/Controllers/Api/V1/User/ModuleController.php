<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\User\ModuleResource;
use App\Models\Module;
use App\Services\Api\V1\User\ModuleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function __construct(public ModuleService $service)
    {
    }

    public function index(Request $request): JsonResponse
    {
        [$modules, $total] = $this->service->index($request);

        return response()->paginate(ModuleResource::collection($modules), $total);
    }

    public function show(Module $module): JsonResponse
    {
        return response()->success(new ModuleResource($module));
    }
}
