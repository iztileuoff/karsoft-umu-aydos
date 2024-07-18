<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Services\Api\V1\User\QuestionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct(public QuestionService $service)
    {
    }

    public function index(Request $request, Result $result): JsonResponse
    {
    }
}
