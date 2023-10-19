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
        $recommendations = array_count_values($submission->document->review()->pluck('recommendation')->toArray());

        $reviewers = $submission->document->users()->count();
        $reviews = $submission->document->review()->count();

        if($reviewers === $reviews)
        {
            $minAgreement = ($reviewers <= 2) ? $reviewers : ceil($reviewers / 2);

            arsort($recommendations);

            $scoreKey = key($recommendations);
            $scoreVal = current($recommendations);

            if ($scoreVal >= $minAgreement)
            {
                $submission->setStatus($scoreKey);
                if($submission->getStatusId() !== 3)
                {
                    $submission->reviewed_at = now();
                    $submission->save();
                }
            }
            else
            {
                $submission->setStatus(3);
                $submission->reviewed_at = null;
                $submission->save();

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
                $submission->setStatus(3);
                $submission->reviewed_at = null;
                $submission->save();
            }
        }
    }
}
