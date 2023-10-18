<?php

namespace App\Observers;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentObserver
{
    /**
     * Handle the Event "updated" event.
     */
    public function updated(Document $document): void
    {
        if($document->isDirty('attachment_author'))
        {
            $originalFile = $document->getOriginal('attachment_author');
    
            Storage::disk('public')->delete($originalFile);
        }
        if($document->isDirty('attachment_no_author'))
        {
            $originalFile = $document->getOriginal('attachment_no_author');
    
            Storage::disk('public')->delete($originalFile);
        }
    }

    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(Document $document): void
    {
        Storage::disk('public')->delete($document->attachment_author);
        Storage::disk('public')->delete($document->attachment_no_author);

    }
}
