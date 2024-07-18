<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\User\ResultResource;
use App\Models\Quiz;
use App\Services\Api\V1\User\QuizResultService;
use Illuminate\Http\JsonResponse;

class QuizResultController extends Controller
{
    public function __construct(public QuizResultService $service)
    {
    }

    public function store(Quiz $quiz): JsonResponse
    {
        $result = $this->service->store($quiz, auth()->user()->id);

        return response()->success(new ResultResource($result));
    }
}
