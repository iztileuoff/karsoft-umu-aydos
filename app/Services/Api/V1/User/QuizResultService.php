<?php

namespace App\Services\Api\V1\User;

use App\Models\Quiz;
use App\Models\Result;

class QuizResultService
{
    public function store(Quiz $quiz, int $user_id): Result
    {
        $questions = $quiz->questions()->select(['id'])->with('options:id,question_id,title,is_correct', 'drags')->get();

        $array = [];

        foreach ($questions as $question) {
            $array[$question['id']] = [
                'is_answered' => false,
                'is_correct' => null,
                'answer_text' => null,
                'drags' => null,
                'options' => null,
            ];
        }

        $result = $quiz->results()->firstOrCreate([
            'user_id' => $user_id
        ]);

        $result->update([
            'started_at' => now(),
            'complated_at' => null,
            'count_questions' => $questions->count(),
            'count_correct_questions' => null,
            'count_incorrect_questions' => null,
        ]);

        $result->questions()->sync($array);

        return $result->load(['questions' => ['questionType', 'randomOptions', 'drags']]);
    }
}
