<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreOptionRequest;
use App\Http\Requests\Api\V1\UpdateOptionRequest;
use App\Http\Resources\V1\Admin\OptionResource;
use App\Models\Option;
use App\Models\Question;
use App\Services\Api\V1\Admin\OptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OptionController extends Controller
{
    public function __construct(public OptionService $service)
    {
    }

    public function index(Request $request, Question $question): JsonResponse
    {
        [$options, $total] = $this->service->index($request, $question);

        return response()->paginate(OptionResource::collection($options), $total);
    }

    public function store(StoreOptionRequest $request, Question $question): JsonResponse
    {
        try {
            $option = $this->service->store($request->validated(), $question);

            return response()->created(new OptionResource($option));
        } catch (ValidationException $exception) {
            return response()->error($exception->getMessage(), 422);
        } catch (\Exception $exception) {
            return response()->error($exception->getMessage(), 500);
        }

    }

    public function update(UpdateOptionRequest $request, Option $option): JsonResponse
    {
        $option = $this->service->update($request->validated(), $option);

        return response()->updated(new OptionResource($option));
    }

    public function destroy(Option $option): JsonResponse
    {
        $this->service->destroy($option);

        return response()->deleted();
    }
}
