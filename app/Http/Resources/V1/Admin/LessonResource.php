<?php

namespace App\Http\Resources\V1\Admin;

use App\Enums\LessonType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Lesson */
class LessonResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'module' => new ModuleResource($this->whenLoaded('module')),
            'module_id' => $this->module_id,
            'lesson_type' => new LessonTypeResource($this->whenLoaded('lessonType')),
            'position' => $this->position,
            'title' => $this->getTranslations('title'),
            'is_free' => $this->is_free,
            'contents' => $this->when($this->lesson_type_id == LessonType::CONTENT->value, ContentResource::collection($this->whenLoaded('contents'))),
            'created_at' => $this->when($request->routeIs('admin.*'), $this->created_at),
            'updated_at' => $this->when($request->routeIs('admin.*'), $this->updated_at),
        ];
    }
}
