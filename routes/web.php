<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    abort(404);
})->name('login');

//handle requests from payment system
Route::any('/handle/{paysys}', function ($paysys) {
    (new Goodoneuz\PayUz\PayUz)->driver($paysys)->handle();
});

//redirect to payment system or payment form
Route::any('/pay/{paysys}/{key}/{amount}', function ($paysys, $key, $amount) {
    $model = Goodoneuz\PayUz\Services\PaymentService::convertKeyToModel($key);
    $url = request('redirect_url', '/'); // redirect url after payment completed
    $pay_uz = new Goodoneuz\PayUz\PayUz;
    $pay_uz
        ->driver($paysys)
        ->redirect($model, $amount, 860, $url);
});
