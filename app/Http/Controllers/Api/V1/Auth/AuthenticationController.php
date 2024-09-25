<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Auth\AuthenticatationUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AuthenticationRequest;
use Illuminate\Http\JsonResponse;

class AuthenticationController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(AuthenticationRequest $request, AuthenticatationUser $authenticatationUser): JsonResponse
    {
        $authenticatationUser->execute($request);

        return response()->ok();
    }
}
