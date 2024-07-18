<?php

namespace App\Services\Api\V1\User;

use App\Enums\QuestionType;
use App\Models\Question;
use App\Models\Result;
use Illuminate\Http\Request;

class ResultQuestionService
{
    public function update(array $validated, Result $result, Question $question): Question
    {
        $question->load(['options']);

        if ($question->question_type_id == QuestionType::Simple->value) {
            $is_correct = false;
            $checked = false;

            foreach ($validated['options'] as $key => $value) {
                $option = $question->options->where('id', $value['id'])->first();

                if (isset($option)) {
                    $validated['options'][$key]['title'] = $option->title;
                    $validated['options'][$key]['is_correct'] = $option->is_correct;


                    if ($value['is_selected'] and !$checked) {
                        $is_correct = $option->is_correct;
                        $checked = true;
                    }
                }
            }

            $result->questions()->syncWithoutDetaching([
                $question->id => [
                    'options' => $validated['options'],
                    'is_answered' => true,
                    'is_correct' => $is_correct
                ]
            ]);
        } elseif ($question->question_type_id == QuestionType::Multiple_choice->value) {
            $is_correct = false;
            $checked = false;

            foreach ($validated['options'] as $key => $value) {
                $option = $question->options->where('id', $value['id'])->first();

                if (isset($option)) {
                    $validated['options'][$key]['title'] = $option->title;
                    $validated['options'][$key]['is_correct'] = $option->is_correct;

                    if (!$checked) {
                        if ($value['is_selected'] or $option->is_correct) {
                            $is_correct = $option->is_correct;

                            if (!$is_correct) {
                                $checked = true;
                            }
                        }
                    }

                }
            }

            $result->questions()->syncWithoutDetaching([
                $question->id => [
                    'options' => $validated['options'],
                    'is_answered' => true,
                    'is_correct' => $is_correct
                ]
            ]);
        } elseif ($question->question_type_id == QuestionType::Sequence->value) {
            $is_correct = false;
            $checked = false;

            foreach ($validated['options'] as $key => $value) {
                $option = $question->options->where('id', $value['id'])->first();

                if (isset($option)) {
                    $validated['options'][$key]['title'] = $option->title;
                    $validated['options'][$key]['is_correct'] = $option->position == $key;

                    if (! $checked) {
                        $is_correct = $option->position == $key;

                        if (! $is_correct) {
                            $checked = true;
                        }
                    }
                }
            }

            $result->questions()->syncWithoutDetaching([
                $question->id => [
                    'options' => $validated['options'],
                    'is_answered' => true,
                    'is_correct' => $is_correct
                ]
            ]);
        } elseif ($question->question_type_id == QuestionType::Drag_and_drop->value) {
            $is_correct = false;
            $checked = false;

            foreach ($validated['options'] as $key => $value) {
                $option = $question->options->where('id', $value['id'])->first();

                if (isset($option)) {
                    $validated['options'][$key]['title'] = $option->title;
                    $validated['options'][$key]['is_correct'] = $option->position == $key;
                    $validated['drags'][$key]['drag_text'] = $option->drag_text;

                    if (! $checked) {
                        $is_correct = $option->position == $key;

                        if (! $is_correct) {
                            $checked = true;
                        }
                    }
                }
            }

            $result->questions()->syncWithoutDetaching([
                $question->id => [
                    'options' => $validated['options'],
                    'drags' => $validated['drags'],
                    'is_answered' => true,
                    'is_correct' => $is_correct
                ]
            ]);
        } elseif ($question->question_type_id == QuestionType::Input->value) {
            $answer_text = $question->options->first()->title;

            if (isset($validated['answer_text'])) {
                $is_correct = $answer_text == $validated['answer_text'];

                $result->questions()->syncWithoutDetaching([
                    $question->id => [
                        'is_answered' => true,
                        'answer_text' => $validated['answer_text'],
                        'is_correct' => $is_correct,
                    ]
                ]);
            }
        }

        if ($is_correct) {
            $result->count_correct_questions += 1;
            $result->save();
        } else {
            $result->count_incorrect_questions += 1;
            $result->save();
        }

//        dd($result->historyQuestions()->where('id', $question->id)->first());
        return $result->historyQuestions()->where('id', $question->id)->first();
    }
}
