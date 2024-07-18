<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Enums\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreImageRequest;
use App\Http\Resources\V1\Admin\ImageResource;
use App\Models\Image;
use App\Services\Api\V1\Admin\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function __construct(public ImageService $service)
    {
    }

    public function index(Request $request): JsonResponse
    {
        [$images, $total] = $this->service->index($request);

        return response()->paginate(ImageResource::collection($images), $total);
    }

    public function store(StoreImageRequest $request): JsonResponse
    {
        [$images, $total] = $this->service->store($request->validated());

        return response()->paginate(
            ImageResource::collection($images),
            $total,
            Message::successfully->value
        );
    }

    public function show(Image $image)
    {
        return response()->success(new ImageResource($image));
    }

    public function destroy(Image $image): JsonResponse
    {
        $this->service->destroy($image);

        return response()->deleted();
    }
}
