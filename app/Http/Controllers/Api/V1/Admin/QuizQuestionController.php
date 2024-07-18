<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreQuestionRequest;
use App\Http\Resources\V1\Admin\QuestionResource;
use App\Models\Quiz;
use App\Services\Api\V1\Admin\QuizQuestionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class QuizQuestionController extends Controller
{
    public function __construct(public QuizQuestionService $service)
    {
    }

    public function index(Request $request, Quiz $quiz): JsonResponse
    {
        [$questions, $total] = $this->service->index($request, $quiz);

        return response()->paginate(QuestionResource::collection($questions), $total);
    }

    public function store(StoreQuestionRequest $request, Quiz $quiz): JsonResponse
    {
        try {
            $question = $this->service->store($request->validated(), $quiz);

            return response()->created(new QuestionResource($question));
        } catch (ValidationException $exception) {
            return response()->error($exception->getMessage(), 422);
        }
    }
}
