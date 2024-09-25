<?php

namespace App\Http\Resources\V1\Admin;

use App\Enums\QuestionType;
use App\Http\Resources\V1\User\OptionItemResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Question */
class QuestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->getTranslations('title'),
            'question_type' => new QuestionTypeResource($this->whenLoaded('questionType')),
            'quiz_id' => $this->when($this->questionable_type == 'App\Models\Quiz', $this->questionable_id),
            'lesson_id' => $this->when($this->questionable_type == 'App\Models\Lesson', $this->questionable_id),
            'answer_explanation' => $this->getTranslations('answer_explanation'),
            'options' => OptionResource::collection($this->whenLoaded('options')),
            'created_at' => $this->when($request->routeIs('admin.*'), $this->created_at?->format('Y-m-d H:i:s')),
            'updated_at' => $this->when($request->routeIs('admin.*'), $this->updated_at?->format('Y-m-d H:i:s')),
        ];
    }
}
