<?php

use App\Http\Controllers\Api\V1\Admin\AudioController;
use App\Http\Controllers\Api\V1\Admin\ContentController;
use App\Http\Controllers\Api\V1\Admin\ImageController;
use App\Http\Controllers\Api\V1\Admin\LessonController;
use App\Http\Controllers\Api\V1\Admin\LessonQuestionController;
use App\Http\Controllers\Api\V1\Admin\LessonTypeController;
use App\Http\Controllers\Api\V1\Admin\ModuleController;
use App\Http\Controllers\Api\V1\Admin\ModuleLessonController;
use App\Http\Controllers\Api\V1\Admin\NotificationController;
use App\Http\Controllers\Api\V1\Admin\OptionController;
use App\Http\Controllers\Api\V1\Admin\OrderController;
use App\Http\Controllers\Api\V1\Admin\PaymentController;
use App\Http\Controllers\Api\V1\Admin\PositionContentController;
use App\Http\Controllers\Api\V1\Admin\PositionLessonController;
use App\Http\Controllers\Api\V1\Admin\PositionOptionController;
use App\Http\Controllers\Api\V1\Admin\QuestionController;
use App\Http\Controllers\Api\V1\Admin\QuestionTypeController;
use App\Http\Controllers\Api\V1\Admin\QuizController;
use App\Http\Controllers\Api\V1\Admin\QuizQuestionController;
use App\Http\Controllers\Api\V1\Admin\RoleController;
use App\Http\Controllers\Api\V1\Admin\TariffController;
use App\Http\Controllers\Api\V1\Admin\UserController;

Route::group([
    'prefix'     => 'admin',
    'as'         => 'admin.',
    'middleware' => ['auth:sanctum'],
], function () {
    Route::apiResources([
        'roles' => RoleController::class,
        'users' => UserController::class,
        'audio' => AudioController::class,
        'images' => ImageController::class,
        'quizzes' => QuizController::class,
        'orders' => OrderController::class,
        'modules' => ModuleController::class,
        'lessons' => LessonController::class,
        'tariffs' => TariffController::class,
        'payments' => PaymentController::class,
        'questions' => QuestionController::class,
        'lesson-types' => LessonTypeController::class,
        'notifications' => NotificationController::class,
        'question-types' => QuestionTypeController::class,
        'modules.lessons' => ModuleLessonController::class,
        'quizzes.questions' => QuizQuestionController::class,
        'lessons.questions' => LessonQuestionController::class,
    ]);

    Route::apiResource('questions.options', OptionController::class)->shallow();
    Route::apiResource('lessons.contents', ContentController::class)->shallow();
    Route::patch('position/modules/{module}', PositionLessonController::class)->name('position.lesson');
    Route::patch('position/questions/{question}', PositionOptionController::class)->name('position.option');
});

