<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreModuleRequest;
use App\Http\Requests\Api\V1\UpdateModuleRequest;
use App\Http\Resources\V1\Admin\ModuleResource;
use App\Models\Module;
use App\Services\Api\V1\Admin\ModuleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function __construct(public ModuleService $service)
    {
    }

    public function index(Request $request)
    {
        [$modules, $total] = $this->service->index($request);

        return response()->paginate(ModuleResource::collection($modules), $total);
    }

    public function store(StoreModuleRequest $request): JsonResponse
    {
        $module = $this->service->store($request->validated());

        return response()->created(new ModuleResource($module));
    }

    public function show(Module $module): JsonResponse
    {
        return response()->success(new ModuleResource($module));
    }

    public function update(UpdateModuleRequest $request, Module $module): JsonResponse
    {
        $module = $this->service->update($request->validated(), $module);

        return response()->updated(new ModuleResource($module));
    }

    public function destroy(Module $module)
    {
        $this->service->destroy($module);

        return response()->deleted();
    }
}
