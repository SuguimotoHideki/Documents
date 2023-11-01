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
            $scoreKey = key($recommendations);
            $scoreFirst = current($recommendations);
            $scoreSecond = next($recommendations);

            if ($scoreFirst > $scoreSecond)
            {
                //dump($submission->document->title, $recommendations, $scoreKey, $scoreFirst, $scoreSecond, '--------------');
                $scoreArray = $reviews->pluck('score')->toArray();
                $submission->setStatus($scoreKey);
                if($submission->getStatusId() !== 3)
                {
                    $submission->reviewed_at = now();
                    $submission->score = array_sum($scoreArray)/count($scoreArray);
                    $submission->save();
                }
            }
            else 
            {
                $submission->setStatus(3);
                $submission->reviewed_at = null;
                $submission->score = null;
                $submission->save();

                $user = User::role('admin')->get();

                if($event->changed)
                {
                    //dump($submission->document->title. ' ' . 'sent');
                    Notification::send($user, new ReviewNotification($submission));
                }
            }
        }
        else
        {
            if($submission->getStatusID() !== 3)
            {
                $submission->setStatus(3);
                $submission->reviewed_at = null;
                $submission->save();
            }
        }
    }
}
