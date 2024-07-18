<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UpdateResultRequest;
use App\Http\Resources\V1\User\ResultResource;
use App\Models\Result;
use App\Services\Api\V1\User\ResultAnswerService;
use Illuminate\Http\JsonResponse;

class ResultAnswerController extends Controller
{
    public function __construct(public ResultAnswerService $service)
    {
    }

    public function __invoke(UpdateResultRequest $request, Result $result): JsonResponse
    {
        $result = $this->service->update($request->validated(), $result);

        return response()->updated(new ResultResource($result));
    }
}
