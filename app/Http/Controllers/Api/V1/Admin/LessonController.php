<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreLessonRequest;
use App\Http\Requests\Api\V1\UpdateLessonRequest;
use App\Http\Resources\V1\Admin\LessonResource;
use App\Models\Lesson;
use App\Services\Api\V1\Admin\LessonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function __construct(public LessonService $service)
    {
    }

    public function index(Request $request)
    {
        [$lessons, $total] = $this->service->index($request);

        return response()->paginate(LessonResource::collection($lessons), $total);
    }

    public function store(StoreLessonRequest $request): JsonResponse
    {
        $module = $this->service->store($request->validated());

        return response()->created(new LessonResource($module));
    }

    public function show(Lesson $lesson): JsonResponse
    {
        return response()->success(new LessonResource($lesson));
    }

    public function update(UpdateLessonRequest $request, Lesson $lesson): JsonResponse
    {
        $lesson = $this->service->update($request->validated(), $lesson);

        return response()->updated(new LessonResource($lesson));
    }

    public function destroy(Lesson $lesson)
    {
        $this->service->destroy($lesson);

        return response()->deleted();
    }
}
