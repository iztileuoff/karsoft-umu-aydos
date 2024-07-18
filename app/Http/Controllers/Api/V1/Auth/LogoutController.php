<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function __invoke(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->ok(Message::logged_out->value);
    }
}
