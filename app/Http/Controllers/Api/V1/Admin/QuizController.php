<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UpdateQuizRequest;
use App\Http\Resources\V1\Admin\QuizResource;
use App\Models\Quiz;
use App\Services\Api\V1\Admin\QuizService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function __construct(public QuizService $service)
    {
    }

    public function index(Request $request)
    {
        [$quizzes, $total] = $this->service->index($request);

        return response()->paginate(QuizResource::collection($quizzes), $total);
    }

    public function show(Quiz $quiz): JsonResponse
    {
        return response()->success(new QuizResource($quiz));
    }

    public function update(UpdateQuizRequest $request, Quiz $quiz): JsonResponse
    {
        $quiz = $this->service->update($request->validated(), $quiz);

        return response()->updated(new QuizResource($quiz));
    }
}
