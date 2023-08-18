<?php

namespace App\Actions;

use App\Models\User;
use App\Models\Event;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Database\QueryException;

Class CreateSubmission extends Controller
{
    public function handle(Document $document, Event $event, User $user)
    {
        //dd($document, $event, $user);
        try
        {
            Submission::create([
                'event_id' => $event->id,
                'document_id' => $document->id,
                'user_id' => $user->id,
                'status' => 4
            ]);
        }
        catch(QueryException $error)
        {
            if($error->getCode() === '23000')
            {
                return redirect()->back()->with('error', 'Você já fez uma submissão para o evento ' . $event->event_name . '.');
            }
            else {
                // Other database-related error occurred
                return redirect()->back()->with('error', 'Ocorreu um erro ao criar a submissão.');
            }
        }
    }
}