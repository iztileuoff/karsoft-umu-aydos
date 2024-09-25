<?php

namespace App\Services\Api\V1\User;

use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LessonService
{
    public function index(Request $request, Module $module): array
    {
        $lessons = $module->lessons()
            ->with(['lessonType', 'oldestContent'])
            ->with(['users' => function (Builder $query) {
                $query->where('id', auth()->id());
            }])
            ->orderBy('position', 'asc');

        $result = $request->limit ? $lessons->paginate($request->limit) : $lessons->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }
}
