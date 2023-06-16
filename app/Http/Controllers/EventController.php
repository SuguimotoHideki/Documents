<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; 
use Illuminate\Database\QueryException;

class EventController extends Controller
{
    //Returns event form view
    public function create()
    {
        return view('events.create');
    }
    
    //Returns all events
    public function index()
    {
        $events = Event::sortable()->paginate();
        return view('events.index', compact('events'));
    }

    public function subscribedEvents()
    {
        $user = Auth::user();

        $subscribbedEvents = $user->events()->sortable()->paginate();
        
        return view('events.indexSubscribbed', [
            'events' => $subscribbedEvents
        ]);
    }

    //Returns event edit form
    public function edit(Event $event)
    {
        return view('events.edit', [
            'event' => $event
        ]);
    }

    //Returns a single event
    public function show(Event $event)
    {
        return view('events.show', [
            'event' => $event
        ]);
    }

    public function subscribe(Event $event)
    {
        $user = Auth::user();
        try
        {
            $event->users()->attach($user->id, ['created_at' => now(), 'updated_at' => now()]);

            return redirect()->route('indexSubscribbedEvents', ['user' => $user])->with('message', 'Inscrito no evento ' . $event->event_name . '.');
        }
        catch(QueryException $error)
        {
            if($error->getCode() === '23000')
            {
                return redirect()->back()->with('error', 'Você já está inscrito neste evento.');
            }
            else {
                // Other database-related error occurred
                return redirect()->back()->with('error', 'Ocorreu um erro ao se inscrever no evento.');
            }
        }
    }

    public function update(Request $request, Event $event)
    {
        $formFields = $request->validate([
            'event_name' => ['required', 'string', Rule::unique('events', 'event_name')->ignore($event, 'id')],
            'event_website' => ['required', 'string'],
            'event_information' => ['required', 'string'],
            'paper_topics' => ['required', 'string'],
            'event_email' => ['required', 'string'],
            'organizer' => ['required', 'string'],
            'organizer_email' => ['required', 'string'],
            'organizer_website' => ['required', 'string'],
            'subscription_start' => ['required', 'date_format:Y-m-d', 'before:subscription_deadline'],
            'subscription_deadline' => ['required', 'date_format:Y-m-d', 'before:submission_start'],
            'submission_start' => ['required', 'date_format:Y-m-d', 'before:submission_deadline'],
            'submission_deadline' => ['required', 'date_format:Y-m-d'],
        ]);

        $event->update($formFields);

        //return redirect()->route('showEvent', [$event])->with('message', 'Event update successful');
        return redirect('/')->with('message', 'Evento ' . $event->event_name . ' atualizado.');
    }

    //Store event
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'event_name' => ['required', 'string', Rule::unique('events', 'event_name')],
            'event_website' => ['required', 'string'],
            'event_information' => ['required', 'string'],
            'paper_topics' => ['required', 'string'],
            'event_email' => ['required', 'string'],
            'organizer' => ['required', 'string'],
            'organizer_email' => ['required', 'string'],
            'organizer_website' => ['required', 'string'],
            'subscription_start' => ['required', 'date_format:Y-m-d', 'before:subscription_deadline'],
            'subscription_deadline' => ['required', 'date_format:Y-m-d', 'before:submission_start'],
            'submission_start' => ['required', 'date_format:Y-m-d', 'before:submission_deadline'],
            'submission_deadline' => ['required', 'date_format:Y-m-d'],
        ]);

        //CHECK STRTOTIME TO FIX THE VALIDATION
        $formFields['event_status'] = Event::getStatus()[0];

        Event::create($formFields);
        return redirect('/')->with('message', 'Evento ' . $formFields['event_name'] . ' criado.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect('/')->with('message', 'Evento ' . $event->event_name . ' removido.');
    }
}
