<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UpdateProfileRequest;
use App\Http\Resources\V1\Admin\UserResource;
use App\Services\Api\V1\User\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(public ProfileService $service)
    {
    }

    public function show(Request $request): JsonResponse
    {
        return response()->success(new UserResource($request->user()));
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user = $this->service->update($request->validated(), $request->user());

        return response()->updated(new UserResource($user));
    }
}
