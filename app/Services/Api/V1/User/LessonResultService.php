<?php

namespace App\Services\Api\V1\User;

use App\Models\Lesson;
use App\Models\Result;

class LessonResultService
{
    public function store(Lesson $lesson, int $user_id): Result
    {
        $questions = $lesson->questions()->select(['id'])->get();

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

        $result = $lesson->results()->firstOrCreate([
            'user_id' => $user_id
        ]);

        // result table update or create
        $result->update([
            'started_at' => now(),
            'complated_at' => null,
            'count_questions' => $questions->count(),
            'count_correct_questions' => null,
            'count_incorrect_questions' => null,
        ]);

        // pivot table clear
        $result->questions()->sync($array);

        return $result->load(['questions' => ['questionType', 'randomOptions', 'drags']]);
    }
}
