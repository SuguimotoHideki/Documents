<?php

namespace App\Actions;

use App\Models\User;
use App\Models\Event;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Submission;

Class CreateSubmission extends Controller
{
    public function handle(Document $document, Event $event, User $user)
    {
        //dd($document, $event, $user);
        Submission::create([
            'event_id' => $event->id,
            'document_id' => $document->id,
            'user_id' => $user->id,
            'status' => 4
        ]);
    }
}