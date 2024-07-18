<?php

namespace App\Services\SendSms;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class EskizService
{
    private static string $token;
    private string $email;
    private string $password;

    /**
     * @throws \ErrorException
     */
    public function __construct()
    {
        $this->email = '';
        $this->password = '';
        self::$token = $this->readToken();
    }

    public static function sendPin($phone_number): int
    {
        // sanitize phone number
        $mobile_phone = self::sanitizePhoneNumber($phone_number);

        // get new pin (integer, 4 digits)
        $pin = self::generatePin();

        $message = "AYDOS mobil qosımshası: {$pin}";

        // send PIN
        $result = self::sendSms(self::$token, $mobile_phone, $message);

        return $pin;
    }

    protected function generatePin(): int
    {
        return rand(1000,9999);
    }

    public function sendSms($token, $mobile_phone, $message): bool
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->post('https://notify.eskiz.uz/api/message/sms/send', [
            'mobile_phone' => $mobile_phone,
            'message' => $message,
            'from' => '4546',
            'callback_url' => config('app.url'),
        ]);

        return $response->successful();
    }

    /**
     * @throws \ErrorException
     */
    public function readToken(): string
    {
        $currentTime = Carbon::now();
        $token = '';

        if(File::exists(config_path('eskizsms.json'))) {
            $config_file = File::get(config_path('eskizsms.json'));
            $conf = json_decode($config_file, true);
            // need to refresh token every 30 days
            if ($currentTime->diffInDays($conf['created']) < 27) {
                $token = $conf['token'];
            } else {
                $token = $this->updateToken($conf['token']);
            }
        } else {
            $token = $this->getToken();
        }

        return $token;
    }

    /**
     * @throws \ErrorException
     */
    public function getToken()
    {
        $response = Http::post('https://notify.eskiz.uz/api/auth/login', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if($response->successful()) {
            $data = $response->json();
            if(!empty($data['data']) && !empty($data['data']['token'])) {
                $this->saveToken($data['data']['token']);
                return $data['data']['token'];
            }
        } else {
            throw new \ErrorException($response->body());
        }
    }

    /**
     * @throws \ErrorException
     */
    public function updateToken($token)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->patch('https://notify.eskiz.uz/api/auth/refresh');

        if($response->successful()) {
            $this->saveToken($token);
        } else {
            throw new \ErrorException($response->body());
        }

        return $token;
    }

    public function saveToken($token): void
    {
        $data = json_encode([
            'created' => date('Y-m-d H:i:s'),
            'token' => $token
        ]);

        File::put(config_path('eskizsms.json'), $data);
    }

    public static function sanitizePhoneNumber($mobile_phone): array|string|null
    {
        return preg_replace('/[^0-9]/', '', $mobile_phone);
    }
}
