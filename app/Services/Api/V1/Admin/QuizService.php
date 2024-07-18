<?php

namespace App\Services\Api\V1\Admin;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizService
{
    public function index(Request $request): array
    {
        $quizzes = Quiz::when($request->search, function ($query) use ($request) {
            $query->search($request->search);
        })->orderBy('id', 'asc');

        $result = $request->limit ? $quizzes->paginate($request->limit) : $quizzes->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }

    public function update(array $validated, Quiz $quiz): Quiz
    {
        $validated['title'] = [
            'ltn' => $validated['title_ltn'],
            'cyr' => $validated['title_cyr'] ?? null,
        ];

        $validated['description'] = [
            'ltn' => $validated['description_ltn'],
            'cyr' => $validated['description_cyr'] ?? null,
        ];

        $quiz->update($validated);

        return $quiz;
    }
}
