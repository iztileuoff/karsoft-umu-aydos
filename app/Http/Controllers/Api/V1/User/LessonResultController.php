<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\User\ResultResource;
use App\Models\Lesson;
use App\Services\Api\V1\User\LessonResultService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LessonResultController extends Controller
{
    public function __construct(public LessonResultService $service)
    {
    }

    public function store(Lesson $lesson): JsonResponse
    {
        $result = $this->service->store($lesson, auth()->user()->id);

        return response()->success(new ResultResource($result));
    }
}
