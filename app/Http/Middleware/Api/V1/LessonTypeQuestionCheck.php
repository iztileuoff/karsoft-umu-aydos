<?php

namespace App\Http\Middleware\Api\V1;

use App\Enums\LessonType;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LessonTypeQuestionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->route('lesson')->lesson_type_id != LessonType::TEST->value) {
            return response()->error('This lesson_type not for QUIZ.', 422);
        }

        return $next($request);
    }
}
