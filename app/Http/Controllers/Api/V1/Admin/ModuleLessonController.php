<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\LessonResource;
use App\Models\Module;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModuleLessonController extends Controller
{
    public function index(Request $request, Module $module): JsonResponse
    {
        $lessons = $module
            ->lessons()
            ->when($request->search, function ($query) use ($request) {
                $query->search($request->search);
            })
//            ->select(['id', 'module_id', 'title', 'position'])
            ->with(['lessonType'])
            ->orderBy('position', 'asc')
            ->get();

        return response()->success(LessonResource::collection($lessons));
    }
}
