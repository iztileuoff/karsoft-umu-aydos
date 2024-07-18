<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\RoleResource;
use App\Models\Role;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    public function index(): JsonResponse
    {
        $roles = Role::where('id', '!=', \App\Enums\Role::SUPER_ADMIN->value)->get();

        return response()->success(RoleResource::collection($roles));
    }
}
