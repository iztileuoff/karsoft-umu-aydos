<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Api\V1\UpdateUserCheck;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Requests\Api\V1\UserRequest;
use App\Http\Resources\V1\Admin\UserResource;
use App\Models\User;
use App\Services\Api\V1\Admin\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(public UserService $service)
    {
//        $this->middleware(UpdateUserCheck::class)->only(['update']);
    }

    public function index(UserRequest $request)
    {
        [$users, $total] = $this->service->index($request);

        return response()->paginate(UserResource::collection($users), $total);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->service->store($request->validated());

        return response()->created(new UserResource($user));
    }

    public function show(User $user): JsonResponse
    {
        return response()->success(new UserResource($user));
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user = $this->service->update($request->validated(), $user);

        return response()->updated(new UserResource($user));
    }

    public function destroy(User $user)
    {
        $this->service->destroy($user);

        return response()->deleted();
    }
}
