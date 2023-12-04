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
            $scoreArray = $reviews->pluck('score')->toArray();
            if ($scoreFirst > $scoreSecond)
            {
                $scoreKey = array_key_first($recommendations);
                //dd($submission->document->title, $recommendations, $scoreKey, $scoreFirst, $scoreSecond, '--------------');
                if($scoreKey === 1)
                {
                    $submission->setReview(true, 0, now());
                }
                else
                {
                    $finalScore = array_sum($scoreArray)/count($scoreArray);
                    $submission->setReview(false, $finalScore, now());
                }
            }
            else
            {
                $finalScore = array_sum($scoreArray)/count($scoreArray);
                $submission->setReview(false, $finalScore, now());
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
