<?php

namespace App\Services\Api\V1\Admin;

use App\Enums\QuestionType;
use App\Models\Lesson;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LessonQuestionService
{
    public function index(Request $request, Lesson $lesson): array
    {
        $questions = $lesson->questions()->when($request->search, function ($query) use ($request) {
            $query->search($request->search);
        })->orderByDesc('id')->with(['questionType']);

        $result = $request->limit ? $questions->paginate($request->limit) : $questions->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }
    public function store(array $validated, Lesson $lesson): Question
    {
        $validated['title'] = [
            'ltn' => $validated['title_ltn'],
            'cyr' => $validated['title_cyr'] ?? null,
        ];

        $validated['answer_explanation'] = [
            'ltn' => $validated['answer_explanation_ltn'] ?? null,
            'cyr' => $validated['answer_explanation_cyr'] ?? null,
        ];

        $question = $lesson->questions()->create($validated);

        return $question->load(['questionType']);
    }
}
