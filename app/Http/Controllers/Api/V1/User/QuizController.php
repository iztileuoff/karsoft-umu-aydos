<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\User\QuizResource;
use App\Http\Resources\V1\User\QuizItemResource;
use App\Models\Quiz;
use App\Services\Api\V1\User\QuizService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function __construct(public QuizService $service)
    {
    }

    public function index(Request $request): JsonResponse
    {
        [$quizzes, $total] = $this->service->index($request);

        return response()->paginate(QuizResource::collection($quizzes), $total);
    }

    public function show(Quiz $quiz): JsonResponse
    {
        return response()->success(new QuizItemResource($quiz));
    }
}
