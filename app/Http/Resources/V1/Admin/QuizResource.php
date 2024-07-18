<?php

namespace App\Http\Resources\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Quiz */
class QuizResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->getTranslations('title'),
            'description' => $this->getTranslations('description'),
            'created_at' => $this->when($request->routeIs('admin.*'), $this->created_at),
            'updated_at' => $this->when($request->routeIs('admin.*'), $this->updated_at),
        ];
    }
}
