<?php

namespace App\Services\Eskiz;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class EskizService
{
    private string $token;
    private string $endpoint = 'https://notify.eskiz.uz/api';
    public function __construct(private readonly int $phone)
    {
        if(!Cache::has('token')) {
            Cache::put('token', $this->getToken(), 60 * 24 * 28);
        }
        $this->token = Cache::get('token');
    }

    public function getToken(): string
    {
        $response = Http::post($this->endpoint . '/auth/login', [
            'email' => config('services.eskiz.email'),
            'password' => config('services.eskiz.password'),
        ]);

        return $response->json()['data']['token'];
    }

    public function sendSms($message): void
    {
        Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])
            ->post($this->endpoint . '/message/sms/send', [
                'mobile_phone' => $this->phone,
                'message' => $message,
                'from' => config('services.eskiz.from')
            ]);
    }
}
