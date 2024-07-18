<?php

namespace App\Services\Api\V1\Admin;

use App\Enums\QuestionType;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OptionService
{
    public function index(Request $request, Question $question): array
    {
        $result = $request->limit ? $question->options()->paginate($request->limit) : $question->options()->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }

    public function store(array $validated, Question $question): Option
    {
        if ($question->question_type_id == QuestionType::Simple->value) {
            if ($validated['is_correct'] && $question->options()->where('is_correct', true)->exists()) {
                throw ValidationException::withMessages([
                    'count_is_correct' => 'Уже есть один правильный ответ.'
                ]);
            }

            $data = [
                'title' => $validated['title'],
                'is_correct' => $validated['is_correct'],
            ];
        } elseif ($question->question_type_id == QuestionType::Multiple_choice->value) {
            $data = [
                'title' => $validated['title'],
                'is_correct' => $validated['is_correct'],
            ];
        } elseif ($question->question_type_id == QuestionType::Sequence->value) {
            $data = [
                'title' => $validated['title'],
            ];
        } elseif ($question->question_type_id == QuestionType::Drag_and_drop->value) {
            if (! isset($validated['drag_text'])) {
                throw ValidationException::withMessages([
                    'drag_text' => 'Текстовое поле перетаскивания является обязательным.'
                ]);
            }

            $data = [
                'title' => $validated['title'],
                'drag_text' => $validated['drag_text'],
            ];
        } else {
            if ($question->options()->exists()) {
                throw ValidationException::withMessages([
                    'count_is_correct' => 'Уже есть один правильный ответ.'
                ]);
            }

            $data = [
                'title' => $validated['title'],
                'is_correct' => true,
            ];
        }

        $data['position'] = $question->options()->count();

        return $question->options()->create($data);
    }

    public function update(array $validated, Option $option): Option
    {
        $question = $option->question;

        if ($question->question_type_id == QuestionType::Simple->value) {
            if ($question->options()->where('id', '!=', $option->id)->where('is_correct', true)->exists()) {
                throw ValidationException::withMessages([
                    'count_is_correct' => 'Уже есть один правильный ответ.'
                ]);
            }

            $data = [
                'title' => $validated['title'],
                'is_correct' => $validated['is_correct'],
            ];
        } elseif ($question->question_type_id == QuestionType::Multiple_choice->value) {
            $data = [
                'title' => $validated['title'],
                'is_correct' => $validated['is_correct'],
            ];
        } elseif ($question->question_type_id == QuestionType::Sequence->value) {
            $data = [
                'title' => $validated['title'],
            ];
        } elseif ($question->question_type_id == QuestionType::Drag_and_drop->value) {
            if (! isset($validated['drag_text'])) {
                throw ValidationException::withMessages([
                    'drag_text' => 'Текстовое поле перетаскивания является обязательным.'
                ]);
            }

            $data = [
                'title' => $validated['title'],
                'drag_text' => $validated['drag_text'],
            ];
        } else {
            $data = [
                'title' => $validated['title'],
                'is_correct' => true,
            ];
        }

        $option->update($data);

        return $option;
    }

    public function destroy(Option $option): void
    {
        $option->delete();
    }
}
