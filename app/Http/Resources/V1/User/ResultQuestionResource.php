<?php

namespace App\Http\Resources\V1\User;

use App\Enums\QuestionType;
use App\Http\Resources\V1\Admin\OptionResource;
use App\Http\Resources\V1\Admin\QuestionTypeResource;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Question */
class ResultQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->translate('title', app()->getLocale()),
            'question_type' => new QuestionTypeResource($this->whenLoaded('questionType')),
            'answer_explanation' => $this->translate('answer_explanation', app()->getLocale()),
            'options' =>  $this->when($this->question_type_id != QuestionType::Input->value, $this->whenPivotLoaded('question_result', function () {
                return json_decode($this->pivot->options, true);
            })),
            'drags' => $this->when($this->question_type_id == QuestionType::Drag_and_drop->value, $this->whenPivotLoaded('question_result', function () {
                return json_decode($this->pivot->drags, true);
            })),
            'answer_text' => $this->when($this->question_type_id == QuestionType::Input->value, $this->whenPivotLoaded('question_result', function () {
                return $this->pivot->answer_text;
            })),
            'is_correct' => $this->whenPivotLoaded('question_result', function () {
                return boolval($this->pivot->is_correct);
            })
        ];
    }
}
