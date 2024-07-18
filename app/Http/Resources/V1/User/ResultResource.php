<?php

namespace App\Http\Resources\V1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Result */
class ResultResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'started_at' => $this->started_at,
            'complated_at' => $this->complated_at,
            'count_correct_questions' => $this->count_correct_questions,
            'count_incorrect_questions' => $this->count_incorrect_questions,
            'count_not_respond_questions' => $this->count_questions - ($this->count_correct_questions + $this->count_incorrect_questions),
            'percent' => $this->count_questions != 0 ? $this->count_correct_questions * 100 / $this->count_questions : $this->count_questions,
            'questions' => $this->when(!$request->routeIs('results.answers'), QuestionResource::collection($this->whenLoaded('questions'))),
            'history_questions' => ResultQuestionResource::collection($this->whenLoaded('historyQuestions')),
//            'history_questions' => ResultQuestionResource::collection($this->whenLoaded('questions')),
        ];
    }
}
