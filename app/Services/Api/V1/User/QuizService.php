<?php

namespace App\Services\Api\V1\User;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizService
{
    public function index(Request $request): array
    {
        $quizzes = Quiz::orderBy('id', 'asc');

        $result = $request->limit ? $quizzes->paginate($request->limit) : $quizzes->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }
}
