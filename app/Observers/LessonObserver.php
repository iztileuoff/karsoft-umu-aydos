<?php

namespace App\Observers;

use App\Models\Lesson;

class LessonObserver
{
    public function created(Lesson $lesson): void
    {

    }

    public function updated(Lesson $lesson): void
    {
    }

    public function deleted(Lesson $lesson): void
    {
        $lesson->module->lessons_re_position();
    }

    public function restored(Lesson $lesson): void
    {
    }
}
