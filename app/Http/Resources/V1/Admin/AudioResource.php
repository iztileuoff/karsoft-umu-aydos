<?php

namespace App\Http\Resources\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Audio */
class AudioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'file_name' => $this->file_name,
            'url' => $this->url,
            'created_at' => $this->when($request->routeIs('admin.*'), date('Y-m-d H:i:s', strtotime($this->created_at?->format('Y-m-d H:i:s')))),
            'updated_at' => $this->when($request->routeIs('admin.*'), date('Y-m-d H:i:s', strtotime($this->updated_at?->format('Y-m-d H:i:s')))),
        ];
    }
}
