<?php

namespace App\Services\Api\V1\User;

use App\Enums\QuestionType;
use App\Models\Result;

class ResultAnswerService
{
    public function update(array $validated, Result $result): Result
    {
        $result->load(['questions:id,question_type_id' => ['options:id,question_id,is_correct,position,title,drag_text']]);
        $data  = [];

        $count_correct_questions = 0;
        $count_incorrect_questions = 0;
//        $collection = collect($validated['questions']);
//        $keyed = $collection->keyBy('id');
//
//        foreach ($result->questions as $question) {
//            $item = $collection->where('id', $question->id)->first();
//
//            if (isset($item)) {
//
//            } else {
//
//            }
//        }

        foreach ($validated['questions'] as $item) {
            $question = $result->questions->where('id', $item['id'])->first();

            if (isset($question)) {

                if ($question->question_type_id == QuestionType::Simple->value) {

                    $is_correct = false;
                    $checked = false;

                    foreach ($item['options'] as $key => $value) {
                        $option = $question->options->where('id', $value['id'])->first();

                        $item['options'][$key]['title'] = $option->title;
                        $item['options'][$key]['is_correct'] = $option->is_correct;

                        if ($value['is_selected'] and !$checked) {
                            $is_correct = $option->is_correct;
                            $checked = true;
                        }
                    }

                    $data[$question->id] = [
                        'options' => $item['options'],
                        'is_answered' => true,
                        'is_correct' => $is_correct
                    ];

                    if ($is_correct) {
                        $count_correct_questions++;
                    } else {
                        $count_incorrect_questions++;
                    }

                } elseif ($question->question_type_id == QuestionType::Multiple_choice->value) {
                    $is_correct = false;
                    $checked = false;

                    foreach ($item['options'] as $key => $value) {
                        $option = $question->options->where('id', $value['id'])->first();

                        $item['options'][$key]['title'] = $option->title;
                        $item['options'][$key]['is_correct'] = $option->is_correct;

                        if (($value['is_selected'] or $option->is_correct) and !$checked) {
                            $is_correct = $value['is_selected'];

                            if (!$is_correct) {
                                $checked = true;
                            }
                        }
                    }

                    $data[$question->id] = [
                        'options' => $item['options'],
                        'is_answered' => true,
                        'is_correct' => $is_correct
                    ];

                    if ($is_correct) {
                        $count_correct_questions++;
                    } else {
                        $count_incorrect_questions++;
                    }

                } elseif ($question->question_type_id == QuestionType::Sequence->value) {
                    $is_correct = false;
                    $checked = false;

                    foreach ($item['options'] as $key => $value) {
                        $option = $question->options->where('id', $value['id'])->first();

                        $item['options'][$key]['title'] = $option->title;
                        $item['options'][$key]['is_correct'] = $option->position == $key;

                        if (! $checked) {
                            $is_correct = $option->position == $key;

                            if (! $is_correct) {
                                $checked = true;
                            }
                        }
                    }

                    $data[$question->id] = [
                        'options' => $item['options'],
                        'is_answered' => true,
                        'is_correct' => $is_correct
                    ];

                    if ($is_correct) {
                        $count_correct_questions++;
                    } else {
                        $count_incorrect_questions++;
                    }

                } elseif ($question->question_type_id == QuestionType::Drag_and_drop->value) {
                    $is_correct = false;
                    $checked = false;

                    foreach ($item['options'] as $key => $value) {
                        $option = $question->options->where('id', $value['id'])->first();

                        $item['options'][$key]['title'] = $option->title;
                        $item['options'][$key]['is_correct'] = $option->position == $key;
                        $item['drags'][$key]['drag_text'] = $option->drag_text;

                        if (! $checked) {
                            $is_correct = $option->position == $key;

                            if (! $is_correct) {
                                $checked = true;
                            }
                        }
                    }

                    $data[$question->id] = [
                        'options' => $item['options'],
                        'drags' => $item['drags'],
                        'is_answered' => true,
                        'is_correct' => $is_correct
                    ];

                    if ($is_correct) {
                        $count_correct_questions++;
                    } else {
                        $count_incorrect_questions++;
                    }

                }  elseif ($question->question_type_id == QuestionType::Input->value) {
                    $answer_text = $question->options->first()->title;
                    $is_correct = $answer_text == $item['answer_text'];

                    $data[$question->id] = [
                        'is_answered' => true,
                        'answer_text' => $item['answer_text'],
                        'is_correct' => $is_correct,
                    ];

                    if ($is_correct) {
                        $count_correct_questions++;
                    } else {
                        $count_incorrect_questions++;
                    }
                }
            }
        }

        $result->questions()->syncWithoutDetaching($data);

        $result->update([
            'complated_at' => now(),
            'count_correct_questions' => $count_correct_questions,
            'count_incorrect_questions' => $count_incorrect_questions,
        ]);

        $result->load(['historyQuestions']);

        return $result;
    }
}
