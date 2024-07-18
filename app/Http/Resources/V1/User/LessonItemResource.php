<?php

namespace App\Http\Resources\V1\User;

use App\Enums\LessonType;
use App\Http\Resources\V1\Admin\LessonTypeResource;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Lesson */
class LessonItemResource extends JsonResource
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
            'lesson_type' => new LessonTypeResource($this->whenLoaded('lessonType')),
            'position' => $this->position,
            'title' => $this->translate('title', app()->getLocale()),
            'is_free' => $this->is_free,
            'content_url' =>  config('app.front_url') . '/content/'. $this->oldestContent->id,
//            'content' => $this->when($this->lesson_type_id == LessonType::CONTENT->value, new ContentResource($this->whenLoaded('oldestContent'))),
            'result' => $this->when($this->lesson_type_id == LessonType::TEST->value, new ResultResource($this->results()->where('user_id', auth()->user()->id)->first())),
        ];
    }
}
