<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Api\V1\ResultQuestionAnsweredCheck;
use App\Http\Requests\Api\V1\UpdateResultQuestionRequest;
use App\Http\Resources\V1\User\ResultQuestionResource;
use App\Models\Question;
use App\Models\Result;
use App\Services\Api\V1\User\ResultQuestionService;
use Illuminate\Http\JsonResponse;

class ResultQuestionController extends Controller
{
    public function __construct(public ResultQuestionService $service)
    {
        $this->middleware(ResultQuestionAnsweredCheck::class);
    }

    public function update(UpdateResultQuestionRequest $request, Result $result, Question $question): JsonResponse
    {
        $question = $this->service->update($request->validated(), $result, $question);

        return response()->updated(new ResultQuestionResource($question));
    }
}
