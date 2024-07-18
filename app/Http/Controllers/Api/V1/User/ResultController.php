<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\User\ResultResource;
use App\Models\Result;
use Illuminate\Http\JsonResponse;

class ResultController extends Controller
{
    public function show(Result $result): JsonResponse
    {
        return response()->success(new ResultResource($result->load(['historyQuestions'])));
//        return response()->success(new ResultResource($result->load(['questions'])));
    }
}
