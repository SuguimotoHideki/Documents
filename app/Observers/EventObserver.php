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
        if ($event->isDirty('logo')) {
            $originalLogo = $event->getOriginal('logo');
            $placeholderLogo = 'event_logos/Placeholder.jpg'; // Change this to match your placeholder file name
    
            // Check if the logo is not the placeholder before deleting
            if ($originalLogo !== $placeholderLogo) {
                Storage::disk('public')->delete($originalLogo);
            }
        }
    }

    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(Event $event): void
    {
        if (!is_null($event->logo)) {
            $placeholderLogo = 'event_logos/Placeholder.jpg'; // Change this to match your placeholder file name
    
            // Check if the logo is not the placeholder before deleting
            if ($event->logo !== $placeholderLogo) {
                Storage::disk('public')->delete($event->logo);
            }
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
