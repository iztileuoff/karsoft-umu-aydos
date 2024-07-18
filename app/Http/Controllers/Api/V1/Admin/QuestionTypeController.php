<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\QuestionTypeResource;
use App\Models\QuestionType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class QuestionTypeController extends Controller
{
    public function index(): JsonResponse
    {
        $question_types = Cache::remember('question_types', 60 * 60, function () {
            return QuestionType::all();
        });

        return response()->success(QuestionTypeResource::collection($question_types));
    }
}
