<?php

namespace App\Http\Resources\V1\User;

use App\Enums\QuestionType;
use App\Http\Resources\V1\Admin\OptionResource;
use App\Http\Resources\V1\Admin\QuestionTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Question */
class QuestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->translate('title', app()->getLocale()),
            'question_type' => new QuestionTypeResource($this->whenLoaded('questionType')),
            'answer_explanation' => $this->translate('answer_explanation', app()->getLocale()),
            'options' =>  $this->when($this->question_type_id != QuestionType::Input->value, OptionResource::collection($this->whenLoaded('randomOptions'))),
            'drags' => $this->when($this->question_type_id == QuestionType::Drag_and_drop->value, OptionItemResource::collection($this->whenLoaded('drags'))),
        ];
    }
}
