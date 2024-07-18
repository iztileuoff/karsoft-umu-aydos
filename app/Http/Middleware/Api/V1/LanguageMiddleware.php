<?php

namespace App\Http\Middleware\Api\V1;

use App\Enums\LessonType;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $language = $request->header('Accept-Language', 'ltn');
        app()->setLocale($language);

        return $next($request);
    }
}
