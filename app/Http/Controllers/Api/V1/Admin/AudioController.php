<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Enums\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreAudioRequest;
use App\Http\Resources\V1\Admin\AudioResource;
use App\Models\Audio;
use App\Services\Api\V1\Admin\AudioService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AudioController extends Controller
{
    public function __construct(public AudioService $service)
    {
    }

    public function index(Request $request): JsonResponse
    {
        [$audios, $total] = $this->service->index($request);

        return response()->paginate(AudioResource::collection($audios), $total);
    }

    public function store(StoreAudioRequest $request): JsonResponse
    {
        [$audios, $total] = $this->service->store($request->validated());

        return response()->paginate(
            AudioResource::collection($audios),
            $total,
            Message::successfully->value
        );
    }

    public function show(Audio $audio)
    {
        return response()->success(new AudioResource($audio));
    }

    public function destroy(Audio $audio): JsonResponse
    {
        $this->service->destroy($audio);

        return response()->deleted();
    }
}
