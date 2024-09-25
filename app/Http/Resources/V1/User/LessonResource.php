<?php

namespace App\Http\Resources\V1\User;

use App\Enums\LessonType;
use App\Http\Resources\V1\Admin\ContentResource;
use App\Http\Resources\V1\Admin\LessonTypeResource;
use App\Http\Resources\V1\Admin\ModuleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Lesson */
class LessonResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'lesson_type' => new LessonTypeResource($this->whenLoaded('lessonType')),
            'position' => $this->position,
            'title' => $this->translate('title', app()->getLocale()),
            'content_url' =>  config('app.front_url') . '/content/'. $this->oldestContent?->id,
            'is_free' => $this->is_free,
            'is_saw' => $this->users()->exists(),
        ];
    }
}
