<?php

namespace App\Actions\Auth;

use App\Enums\Role;
use App\Http\Requests\Api\V1\AuthenticationRequest;
use App\Models\User;
use App\Services\Eskiz\EskizService;
use App\Services\SendSms\PlayMobileService;
use Illuminate\Support\Facades\Cache;

class AuthenticatationUser
{
    /**
     * @throws \Exception
     */
    public function execute(AuthenticationRequest $request): void
    {
        $user = User::firstOrCreate([
            'phone' => $request->phone
        ], [
            'role_id' => Role::USER->value,
        ]);

        $sanitizePhoneNumber = preg_replace('/[^0-9]/', '', $request->phone);
//        $eskizService = new EskizService($sanitizePhoneNumber);

//        $pinCode = rand(1000,9999);
//        $message = "Ваш код подтверждения UMU Aydos: {$pinCode}";
//        $eskizService->sendSms($message);

        Cache::forget($user->phone);
        Cache::put($user->phone, 1111, now()->addMinutes(3));
    }
}
