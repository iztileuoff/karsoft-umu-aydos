<?php

namespace App\Http\Resources\V1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Content */
class ContentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->translate('title', app()->getLocale()),
            'body' => $this->translate('body', app()->getLocale()),
//            'url' => $this->when(! $request->routeIs('admin.*'), config('app.front_url') . '/content/'. $this->id)
        ];
    }
}
