<?php

use App\Http\Controllers\Api\V1\User\LessonController;
use App\Http\Controllers\Api\V1\User\LessonResultController;
use App\Http\Controllers\Api\V1\User\ModuleController;
use App\Http\Controllers\Api\V1\User\NotificationController;
use App\Http\Controllers\Api\V1\User\OrderController;
use App\Http\Controllers\Api\V1\User\ProfileController;
use App\Http\Controllers\Api\V1\User\QuestionController;
use App\Http\Controllers\Api\V1\User\QuizController;
use App\Http\Controllers\Api\V1\User\QuizResultController;
use App\Http\Controllers\Api\V1\User\ResultAnswerController;
use App\Http\Controllers\Api\V1\User\ResultController;
use App\Http\Controllers\Api\V1\User\ResultQuestionController;
use App\Http\Controllers\Api\V1\User\TariffController;
use App\Http\Middleware\Api\V1\LanguageMiddleware;

Route::group([
    'middleware' => ['auth:sanctum', LanguageMiddleware::class],
], function () {
    Route::apiSingleton('profile', ProfileController::class);
    Route::apiResource('modules.lessons', LessonController::class)->shallow();
    Route::patch('results/{result}/answers', ResultAnswerController::class)->name('results.answers');

    Route::apiResources([
        'quizzes' => QuizController::class,
        'results' => ResultController::class,
        'modules' => ModuleController::class,
        'tariffs' => TariffController::class,
        'tariffs.orders' => OrderController::class,
        'notifications' => NotificationController::class,
        'quizzes.results' => QuizResultController::class,
        'lessons.results' => LessonResultController::class,
        'results.questions' => ResultQuestionController::class,
    ]);
});
