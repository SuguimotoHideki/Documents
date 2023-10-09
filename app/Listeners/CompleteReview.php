<?php

namespace App\Listeners;

use App\Events\ReviewCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CompleteReview
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ReviewCreated $event): void
    {
        $submission = $event->submission;
        $reviewers = $submission->document->users()->count();
        $reviews = $submission->document->review()->count();

        if($reviewers === $reviews)
        {
            $recomArr = array_count_values($submission->document->review()->pluck('recommendation')->toArray());
            arsort($recomArr);
            $submission->setStatus(key($recomArr));
            //dd($submission->status, $submission->document->review()->pluck('recommendation')->toArray(), array_count_values($submission->document->review()->pluck('recommendation')->toArray()));
        }
        elseif($reviews < $reviewers)
        {
            $submission->setStatus(3);
        }
        
        //dd($reviewers, $reviews);
    }
}
