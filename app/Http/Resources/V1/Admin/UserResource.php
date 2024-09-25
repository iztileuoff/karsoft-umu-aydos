<?php

namespace App\Http\Resources\V1\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin User **/
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->when($request->routeIs('admin.*'), $this->id),
            'name' => $this->name,
            'phone' => $this->phone,
            'role_id' => $this->role_id,
            'role_name' => $this->role->name,
            'available_to' => $this->available_to,
            'level' => $this->profile->level,
            'created_at' => $this->when($request->routeIs('admin.*'), $this->created_at?->format('Y-m-d H:i:s')),
            'updated_at' => $this->when($request->routeIs('admin.*'), $this->updated_at?->format('Y-m-d H:i:s')),
        ];
    }
}
