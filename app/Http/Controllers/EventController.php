<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 

class EventController extends Controller
{
    //Returns event form view
    public function create()
    {
        return view('events.create');
    }
    
    //Store event
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'event_name' => ['required', 'string', Rule::unique('events', 'event_name')],
            'event_website' => ['required', 'string'],
            'event_information' => ['required', 'string'],
            'paper_topics' => ['required', 'string'],
            'paper_tracks' => ['required', 'string'],
            'event_email' => ['required', 'string'],
            'organizer' => ['required', 'string'],
            'organizer_email' => ['required', 'string'],
            'organizer_website' => ['required', 'string'],
            'subscription_deadline' => ['required', 'date_format:Y-m-d', 'before:start_date'],
            'submission_deadline' => ['required', 'date_format:Y-m-d', 'before:end_date'],
            'start_date' => ['required', 'date_format:Y-m-d', 'before:end_date'],
            'end_date' => ['required', 'date_format:Y-m-d']
        ]);

        //CHECK STRTOTIME TO FIX THE VALIDATION
        $formFields['event_status'] = 0;

        Event::create($formFields);
        return redirect('/')->with('message', 'Event created.');
    }
}
