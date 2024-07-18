<?php

namespace App\Http\Middleware\Api\V1;

use App\Enums\LessonType;
use App\Enums\Message;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LessonTypeContentCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->route('lesson')->lesson_type_id != LessonType::CONTENT->value) {
            return response()->error('This lesson_type not for CONTENT.', 422);
        }

        if($request->route('lesson')->contents()->exists()) {
            return response()->error(Message::lesson_have_content->value, 422);
        }

        return $next($request);
    }
}
