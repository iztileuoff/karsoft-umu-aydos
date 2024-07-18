<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreNotificationRequest;
use App\Http\Requests\Api\V1\UpdateNotificationRequest;
use App\Http\Resources\V1\Admin\NotificationResource;
use App\Models\Notification;
use App\Services\Api\V1\Admin\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(public NotificationService $service)
    {
    }

    public function index(Request $request): JsonResponse
    {
        [$notifications, $total] = $this->service->index($request);

        return response()->paginate(NotificationResource::collection($notifications), $total);
    }

    public function store(StoreNotificationRequest $request): JsonResponse
    {
        $notification = $this->service->store($request->validated());

        return response()->created(new NotificationResource($notification));
    }

    public function show(Notification $notification): JsonResponse
    {
        return response()->success(new NotificationResource($notification));
    }

    public function update(UpdateNotificationRequest $request, Notification $notification): JsonResponse
    {
        $notification = $this->service->update($request->validated(), $notification);

        return response()->updated(new NotificationResource($notification));
    }

    public function destroy(Notification $notification): JsonResponse
    {
        $this->service->destroy($notification);

        return response()->deleted();
    }
}
