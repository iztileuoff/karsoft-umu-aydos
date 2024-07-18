<?php

namespace App\Services\Api\V1\Admin;

use App\Enums\QuestionType;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class QuizQuestionService
{
    public function index(Request $request, Quiz $quiz): array
    {
        $questions = $quiz->questions()->when($request->search, function ($query) use ($request) {
            $query->search($request->search);
        })->orderByDesc('id')->with(['questionType']);

        $result = $request->limit ? $questions->paginate($request->limit) : $questions->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }

    public function store(array $validated, Quiz $quiz): Question
    {
        $validated['title'] = [
            'ltn' => $validated['title_ltn'],
            'cyr' => $validated['title_cyr'] ?? null,
        ];

        $validated['answer_explanation'] = [
            'ltn' => $validated['answer_explanation_ltn'] ?? null,
            'cyr' => $validated['answer_explanation_cyr'] ?? null,
        ];

        $question = $quiz->questions()->create($validated);

        return $question->load(['questionType']);
    }
}
