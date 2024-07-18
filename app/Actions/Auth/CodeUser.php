<?php

namespace App\Actions\Auth;

use App\Enums\Role;
use App\Http\Requests\Api\V1\CodeRequest;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class CodeUser
{
    public function execute(CodeRequest $request): array
    {
        $code = Cache::get($request->phone);

        if ($code != $request->verification_code) {
            throw ValidationException::withMessages([
                'code' => 'Kiritken kodıńız qáte.'
            ]);
        }

        Cache::forget($request->phone);
        $user = User::phone($request->phone)->first();
        $user->tokens()->delete();

        $device = substr($request->userAgent() ?? '', 0, 255);

        return [$user->createToken($device)->plainTextToken];
    }
}
