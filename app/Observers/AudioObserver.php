<?php

namespace App\Observers;

use App\Models\Audio;
use Illuminate\Support\Facades\Storage;

class AudioObserver
{
    /**
     * Handle the Audio "created" event.
     */
    public function created(Audio $audio): void
    {
        //
    }

    /**
     * Handle the Audio "updated" event.
     */
    public function updated(Audio $audio): void
    {
        //
    }

    /**
     * Handle the Audio "deleted" event.
     */
    public function deleted(Audio $audio): void
    {
        Storage::disk('public')->delete('audio/' . $audio->file_name);
    }

    /**
     * Handle the Audio "restored" event.
     */
    public function restored(Audio $audio): void
    {
        //
    }

    /**
     * Handle the Audio "force deleted" event.
     */
    public function forceDeleted(Audio $audio): void
    {
        //
    }
}
