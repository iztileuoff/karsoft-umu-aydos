<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\User\LessonResource;
use App\Http\Resources\V1\User\LessonItemResource;
use App\Models\Lesson;
use App\Models\Module;
use App\Services\Api\V1\User\LessonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function __construct(public LessonService $service)
    {
    }

    public function index(Request $request, Module $module): JsonResponse
    {
        [$lessons, $total] = $this->service->index($request, $module);

        return response()->paginate(LessonResource::collection($lessons), $total);
    }

    public function show(Lesson $lesson): JsonResponse
    {
        return response()->success(new LessonItemResource($lesson->load(['oldestContent', 'results'])));
    }
}
