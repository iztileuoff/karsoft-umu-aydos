<?php

namespace App\Providers;

use App\Enums\Message;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('paginate', function ($data, $total, $message = Message::successfully->value) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data,
                'total' => $total
            ]);
        });

        Response::macro('success', function ($data, $message = Message::successfully->value) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data
            ]);
        });

        Response::macro('ok', function ($message = Message::successfully->value) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        });

        Response::macro('created', function ($data, $message = Message::created->value) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data
            ], 201);
        });

        Response::macro('updated', function ($data, $message = Message::updated->value) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data
            ]);
        });

        Response::macro('deleted', function ($message = Message::deleted->value) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        });

        Response::macro('error', function ($message, $status_code) {
            return response()->json([
                'success' => false,
                'message' => $message
            ], $status_code);
        });
    }
}
