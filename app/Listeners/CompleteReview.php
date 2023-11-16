<?php

namespace App\Listeners;

use App\Events\ReviewCreated;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\ReviewNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

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

        $reviewers = $submission->document->users();
        $reviews = $submission->document->review();

        if($reviewers->count() === $reviews->count())
        {
            $recommendations = array_count_values($reviews->pluck('recommendation')->toArray());
            arsort($recommendations);
            $scoreFirst = current($recommendations);
            $scoreSecond = next($recommendations);

            if ($scoreFirst > $scoreSecond)
            {
                $scoreKey = array_key_first($recommendations);
                //dump($submission->document->title, $recommendations, $scoreKey, $scoreFirst, $scoreSecond, '--------------');
                $scoreArray = $reviews->pluck('score')->toArray();
                if($scoreKey !== 3)
                {
                    $submission->setReview($scoreKey, array_sum($scoreArray)/count($scoreArray), now());
                }
            }
            else 
            {
                $submission->unsetReview();
                $user = User::role('admin')->get();
                if($event->changed)
                {
                    Notification::send($user, new ReviewNotification($submission));
                }
            }
        }
        else
        {
            if($submission->getStatusID() !== 3)
            {
                $submission->unsetReview();
            }
        }
    }
}
