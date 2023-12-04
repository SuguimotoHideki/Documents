<?php

namespace App\Actions;

use App\Http\Controllers\Controller;
use App\Models\Event;

Class SyncReviewScores extends Controller
{
    public function handle($formFields, Event $event)
    {
        $reviewValues = array_values($formFields['score']);
        $reviewKeys = array_keys($formFields['score']);
        $dataToSync = [];
        $recommendation = $formFields['recommendation'];
        $reviewScore = array_sum($reviewValues)/count($reviewValues);
        foreach ($reviewKeys as $index => $key) {
            $dataToSync[$key] = ['score' => $reviewValues[$index]];
        }
        if($recommendation != 1)
        {
            if($reviewScore >= $event->passing_grade)
                $recommendation = 0;
            else
                $recommendation = 2;
        }
        return [$dataToSync, $reviewScore, $recommendation];
    }
}