<?php

namespace App\Services\Api\V1\Admin;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class QuestionService
{
    public function index(Request $request): array
    {
        $questionable_type = match ($request->type) {
            'lesson' => 'App\Models\Lesson',
            'quiz' => 'App\Models\Quiz'
        };

        $questions = Question::where('questionable_type', $questionable_type)
            ->orderByDesc('id')->with(['questionType']);

        $result = $request->limit ? $questions->paginate($request->limit) : $questions->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }

    public function update(array $validated, Question $question, $options): Question
    {
        $validated['title'] = [
            'ltn' => $validated['title_ltn'],
            'cyr' => $validated['title_cyr'] ?? null,
        ];

        $validated['answer_explanation'] = [
            'ltn' => $validated['answer_explanation_ltn'] ?? null,
            'cyr' => $validated['answer_explanation_cyr'] ?? null,
        ];

        if (isset($validated['lesson_id'])) {
            $validated['questionable_id'] = $validated['lesson_id'];
        } elseif (isset($validated['quiz_id'])) {
            $validated['questionable_id'] = $validated['quiz_id'];
        }

        $question->update($validated);

        return  $question->load(['questionType']);
    }

    public function destroy(Question $question): void
    {
        $question->delete();
    }
}
