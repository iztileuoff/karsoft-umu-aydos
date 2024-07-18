<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\QuestionRequest;
use App\Http\Requests\Api\V1\UpdateQuestionRequest;
use App\Http\Resources\V1\Admin\QuestionResource;
use App\Models\Question;
use App\Services\Api\V1\Admin\QuestionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class QuestionController extends Controller
{
    public function __construct(public QuestionService $service)
    {
    }

    public function index(QuestionRequest $request): JsonResponse
    {
        [$questions, $total] = $this->service->index($request);

        return response()->paginate(QuestionResource::collection($questions), $total);
    }

    public function show(Question $question): JsonResponse
    {
        return response()->success(new QuestionResource($question->load(['questionType'])));
    }

    public function update(UpdateQuestionRequest $request, Question $question): JsonResponse
    {
        try {
            $question = $this->service->update($request->validated(), $question, $request->options);

            return response()->updated(new QuestionResource($question));
        } catch (ValidationException $exception) {
            return response()->error($exception->getMessage(), 422);
        }
    }

    public function destroy(Question $question): JsonResponse
    {
        $this->service->destroy($question);

        return response()->deleted();
    }
}
