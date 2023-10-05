<?php

namespace App\Actions;

use App\Http\Controllers\Controller;

Class SyncReviewScores extends Controller
{
    public function handle($formFields)
    {
        $reviewValues = array_values($formFields['score']);
        $reviewKeys = array_keys($formFields['score']);
        
        $dataToSync = [];
        
        foreach ($reviewKeys as $index => $key) {
            $dataToSync[$key] = ['score' => $reviewValues[$index]];
        }

        return [$dataToSync, array_sum($reviewValues)/count($reviewValues)];
    }
}