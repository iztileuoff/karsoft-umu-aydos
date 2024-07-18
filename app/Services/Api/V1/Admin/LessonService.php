<?php

namespace App\Services\Api\V1\Admin;

use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;

class LessonService
{
    public function index(Request $request): array
    {
        $lessons = Lesson::when($request->title, function ($query) use ($request) {
            $query->title($request->title);
        })->when($request->module_id, function ($query) use ($request) {
            $query->moduleId($request->module_id);
        })->when($request->lesson_type_id, function ($query) use ($request) {
            $query->lessonTypeId($request->lesson_type_id);
        })->with(['lessonType'])->orderBy('id', 'desc');

        $result = $request->limit ? $lessons->paginate($request->limit) : $lessons->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }

    public function store(array $validated): Lesson
    {
        $validated['position'] = Lesson::where('module_id', $validated['module_id'])->count();

        $validated['title'] = [
            'ltn' => $validated['title_ltn'],
            'cyr' => $validated['title_cyr'] ?? null,
        ];

        return Lesson::create($validated);
    }

    public function update(array $validated, Lesson $lesson): Lesson
    {
        $validated['title'] = [
            'ltn' => $validated['title_ltn'],
            'cyr' => $validated['title_cyr'] ?? null,
        ];

        $lesson->update($validated);

        return $lesson;
    }

    public function destroy(Lesson $lesson): void
    {
        $lesson->delete();
    }
}
