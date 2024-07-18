<?php

namespace App\Providers;

use App\Models\Audio;
use App\Models\Image;
use App\Models\Lesson;
use App\Models\Option;
use App\Models\User;
use App\Observers\AudioObserver;
use App\Observers\ImageObserver;
use App\Observers\LessonObserver;
use App\Observers\OptionObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        Audio::class => [AudioObserver::class],
        Image::class => [ImageObserver::class],
        Option::class => [OptionObserver::class],
        User::class => [UserObserver::class],
        Lesson::class => [LessonObserver::class]
    ];

    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
