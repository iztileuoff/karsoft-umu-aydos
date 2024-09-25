<?php

namespace App\Services\Api\V1\User;

use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;

class LessonService
{
    public function index(Request $request, Module $module): array
    {
        $lessons = Lesson::where('module_id', $module->id)
            ->with(['lessonType', 'oldestContent', 'users' => function ($query) {
                $query->where('id', auth()->id());
            }])
            ->orderBy('position', 'asc');

        $result = $request->limit ? $lessons->paginate($request->limit) : $lessons->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }
}
