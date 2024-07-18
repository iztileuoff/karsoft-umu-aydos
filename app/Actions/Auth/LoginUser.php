<?php

namespace App\Actions\Auth;

use App\Http\Requests\Api\V1\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginUser
{
    public function execute(LoginRequest $request): array
    {
        $user = User::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password) || !$user->isAdmin()) {
            throw ValidationException::withMessages([
                'phone' => ['Номер телефона или пароль введены неверно.'],
            ]);
        }

        return [$user->createToken('api_token')->plainTextToken];
    }
}
