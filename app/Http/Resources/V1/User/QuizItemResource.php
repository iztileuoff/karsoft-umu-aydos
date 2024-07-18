<?php

namespace App\Http\Resources\V1\User;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Quiz */
class QuizItemResource extends JsonResource
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
            'description' => $this->translate('description', app()->getLocale()),
            'result' => new ResultResource($this->results()->where('user_id', auth()->user()->id)->with('historyQuestions')->first()),
        ];
    }
}
