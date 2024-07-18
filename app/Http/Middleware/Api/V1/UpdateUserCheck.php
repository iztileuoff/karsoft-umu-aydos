<?php

namespace App\Http\Middleware\Api\V1;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->route('user')->role_id == Role::USER->value) {
            return response()->error('Tek adminlerdi update qiliwǵa boladı.', 422);
        }

        return $next($request);
    }
}
