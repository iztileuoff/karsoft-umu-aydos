<?php

namespace App\Http\Resources\V1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Module */
class ModuleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->translate('title', app()->getLocale()),
            'description' => $this->when(! $request->routeIs('*.index'), $this->translate('description', app()->getLocale())),
            'lessons_count' => $this->whenCounted('lessons'),
        ];
    }
}
