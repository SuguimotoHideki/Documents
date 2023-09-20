<?php

namespace App\Observers;

use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     */
    public function created(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "updated" event.
     */
    public function updated(Event $event): void
    {
        //dd($event->logo);
        if ($event->isDirty('logo')) {
            Storage::disk('public')->delete($event->getOriginal('logo'));
        }
    }

    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(Event $event): void
    {
        if (! is_null($event->logo)) {
            Storage::disk('public')->delete($event->logo);
        }
    }

    /**
     * Handle the Event "restored" event.
     */
    public function restored(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "force deleted" event.
     */
    public function forceDeleted(Event $event): void
    {
        //
    }
}
