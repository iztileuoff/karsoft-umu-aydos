<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Auth\CodeUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CodeRequest;
use Illuminate\Validation\ValidationException;

class CodeController extends Controller
{
    public function __invoke(CodeRequest $request, CodeUser $codeUser)
    {
        try {
            [$access_token] = $codeUser->execute($request);

            return response()->success([
                'access_token' => $access_token,
                'token_type' => 'Bearer'
            ]);
        } catch (ValidationException $exception) {
            return response()->error($exception->getMessage(), 422);
        }
    }
}
