<?php

namespace App\Http\Resources\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Content */
class ContentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'lesson_id' => $this->lesson_id,
            'title' => $this->getTranslations('title'),
            'body' => $this->getTranslations('body'),
            'position' => $this->position,
            'created_at' => $this->when($request->routeIs('admin.*'), $this->created_at?->format('Y-m-d H:i:s')),
            'updated_at' => $this->when($request->routeIs('admin.*'), $this->updated_at?->format('Y-m-d H:i:s')),
        ];
    }
}
