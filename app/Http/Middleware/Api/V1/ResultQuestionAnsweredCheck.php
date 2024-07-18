<?php

namespace App\Http\Middleware\Api\V1;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResultQuestionAnsweredCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->route('result')->questions()->where('id', $request->route('question')->id)->first()->pivot->is_answered) {
            return response()->error('This question already answered', 422);
        }

        return $next($request);
    }
}
