<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UpdatePositionLessonRequest;
use App\Http\Requests\Api\V1\UpdatePositionOptionRequest;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PositionLessonController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdatePositionLessonRequest $request, Module $module)
    {
        if(count($request->lessons) != $module->lessons()->count()) {
            throw ValidationException::withMessages([
                'lessons_count' => 'Please, send all lesson ids.'
            ]);
        }

        $lessons_count = 0;

        foreach ($request->lessons as $lesson_id) {
            Lesson::where('module_id', $module->id)
                ->where('id', $lesson_id)
                ->update(['position' => $lessons_count]);
            $lessons_count++;
        }

        return response()->ok();
    }
}
