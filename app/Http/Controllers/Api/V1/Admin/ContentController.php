<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Api\V1\LessonTypeContentCheck;
use App\Http\Requests\Api\V1\StoreContentRequest;
use App\Http\Requests\Api\V1\UpdateContentRequest;
use App\Http\Resources\V1\Admin\ContentResource;
use App\Models\Content;
use App\Models\Lesson;
use App\Services\Api\V1\Admin\ContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function __construct(public ContentService $service)
    {
        $this->middleware(LessonTypeContentCheck::class)->only(['store']);
    }

    public function index(Request $request, Lesson $lesson): JsonResponse
    {
        [$contents, $total] = $this->service->index($request, $lesson);

        return response()->paginate(ContentResource::collection($contents), $total);
    }

    public function store(StoreContentRequest $request, Lesson $lesson): JsonResponse
    {
        $content = $this->service->store($request->validated(), $lesson);

        return response()->created(new ContentResource($content));
    }

    public function show(Content $content): JsonResponse
    {
        return response()->success(new ContentResource($content));
    }

    public function update(UpdateContentRequest $request, Content $content): JsonResponse
    {
        $content = $this->service->update($request->validated(), $content);

        return response()->updated(new ContentResource($content));
    }

    public function destroy(Content $content)
    {
        $this->service->destroy($content);

        return response()->deleted();
    }
}
