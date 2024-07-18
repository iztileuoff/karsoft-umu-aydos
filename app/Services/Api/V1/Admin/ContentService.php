<?php

namespace App\Services\Api\V1\Admin;

use App\Models\Content;
use App\Models\Lesson;
use Illuminate\Http\Request;

class ContentService
{
    public function index(Request $request, Lesson $lesson): array
    {
        $contents = $lesson
            ->contents()
//            ->select(['id', 'lesson_id', 'position', 'title', 'updated_at', 'created_at'])
            ->orderBy('position', 'asc');

        $result = $request->limit ? $contents->paginate($request->limit) : $contents->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }

    public function store(array $validated, Lesson $lesson): Content
    {
        $validated['position'] = $lesson->contents()->count();

        $validated['title'] = [
            'ltn' => $validated['title_ltn'],
            'cyr' => $validated['title_cyr'] ?? null,
        ];

        $validated['body'] = [
            'ltn' => $validated['body_ltn'],
            'cyr' => $validated['body_cyr'] ?? null,
        ];

        return $lesson->contents()->create($validated);
    }

    public function update(array $validated, Content $content): Content
    {
        $validated['title'] = [
            'ltn' => $validated['title_ltn'],
            'cyr' => $validated['title_cyr'] ?? null,
        ];

        $validated['body'] = [
            'ltn' => $validated['body_ltn'],
            'cyr' => $validated['body_cyr'] ?? null,
        ];

        $content->update($validated);

        return $content;
    }

    public function destroy(Content $content): void
    {
        $content->delete();
    }
}
