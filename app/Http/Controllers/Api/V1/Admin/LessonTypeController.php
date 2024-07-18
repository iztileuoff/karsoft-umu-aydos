<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\LessonTypeResource;
use App\Models\LessonType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class LessonTypeController extends Controller
{
    public function index(): JsonResponse
    {
        $lesson_types = Cache::remember('lesson_types', 60 * 60, function () {
            return LessonType::all();
        });

        return response()->success(LessonTypeResource::collection($lesson_types));
    }
}
