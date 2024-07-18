<?php

namespace App\Http\Resources\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Option */
class OptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'drag_text' => $this->when($request->routeIs('admin.*'), $this->drag_text),
            'is_correct' => $this->when($request->routeIs('admin.*'), $this->is_correct),
            'position' => $this->when($request->routeIs('admin.*'), $this->position),
            'created_at' => $this->when($request->routeIs('admin.*'), $this->created_at),
            'updated_at' => $this->when($request->routeIs('admin.*'), $this->updated_at),
        ];
    }
}
