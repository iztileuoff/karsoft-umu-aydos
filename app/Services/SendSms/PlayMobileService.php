<?php

namespace App\Services\SendSms;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PlayMobileService
{
    public function __construct(public string $phone)
    {
    }

    /**
     * @throws \Exception
     */
    public function handle(string $text): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
    {
        $endpoint = config('main.sms.endpoint');
        $auth = config('main.sms.auth');

        $body = [
            "messages" => [
                [
                    "recipient" => $this->phone,
                    "message-id" => Str::uuid()->toString(),
                    "sms" => [
                        "originator" => "3700",
                        "content" => [
                            "text" => $text
                        ]
                    ]
                ]
            ]
        ];

        return Http::withHeaders([
            'Authorization' => 'Basic ' . $auth
        ])->withBody(json_encode($body), 'application/json')->send('post', $endpoint);
    }
}
