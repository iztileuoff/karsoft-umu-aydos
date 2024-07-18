<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Api\V1\LessonTypeQuestionCheck;
use App\Http\Requests\Api\V1\StoreQuestionRequest;
use App\Http\Resources\V1\Admin\QuestionResource;
use App\Models\Lesson;
use App\Services\Api\V1\Admin\LessonQuestionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LessonQuestionController extends Controller
{
    public function __construct(public LessonQuestionService $service)
    {
        $this->middleware(LessonTypeQuestionCheck::class)->only(['store']);
    }

    public function index(Request $request, Lesson $lesson): JsonResponse
    {
        [$questions, $total] = $this->service->index($request, $lesson);

        return response()->paginate(QuestionResource::collection($questions), $total);
    }

    public function store(StoreQuestionRequest $request, Lesson $lesson): JsonResponse
    {
        try {
            $question = $this->service->store($request->validated(), $lesson);

            return response()->created(new QuestionResource($question));
        } catch (ValidationException $exception) {
            return response()->error($exception->getMessage(), 422);
        }
    }
}
