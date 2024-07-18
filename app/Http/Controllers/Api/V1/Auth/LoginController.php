<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Auth\LoginUser;
use App\Enums\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:apiLogin');
    }

    public function __invoke(LoginRequest $request, LoginUser $loginUser)
    {
        [$access_token] = $loginUser->execute($request);

        return response()->success([
            'access_token' => $access_token,
            'token_type' => 'Bearer'
        ], Message::login_success->value);
    }
}
