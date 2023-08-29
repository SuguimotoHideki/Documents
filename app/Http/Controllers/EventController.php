<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\QueryException;

class EventController extends Controller
{
    //Returns all events
    public function index()
    {
        $events = Event::where('event_published', true)->sortable()->paginate();
        return view('events.index', compact('events'));
    }

    //Returns a single event
    public function show(Event $event)
    {    
        $user = Auth::user();
        $pivotData = null;

        if($event->hasUser($user))
            $pivotData = $user->events->find($event->id)->pivot;

        return view('events.show', [
            'event' => $event,
            'subscription' => $pivotData
        ]);
    }    

    //Returns event management page
    public function dashboard()
    {
        $user = Auth::user();

        $this->authorize('dashboard', Event::class);

        if($user->hasRole('event moderator'))
        {
            $events = $user->eventsModerated()->sortable()->paginate();
        }
        elseif($user->hasRole('admin'))
        {
            $events = Event::sortable()->paginate();
        }

        return view('events.dashboard', compact('events'));
    }

    //Returns event edit form
    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        return view('events.edit', [
            'event' => $event
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);
        
        $formFields = $request->validate([
            'event_name' => ['required', 'string', Rule::unique('events', 'event_name')->ignore($event, 'id')],
            'event_website' => ['required', 'string'],
            'event_information' => ['required', 'string'],
            'paper_topics' => ['required', 'string'],
            'event_email' => ['required', 'string'],
            'organizer' => ['required', 'string'],
            'event_status' => ['required'],
            'organizer_email' => ['required', 'string'],
            'organizer_website' => ['required', 'string'],
            'subscription_start' => ['required', 'date_format:Y-m-d', 'before:subscription_deadline'],
            'subscription_deadline' => ['required', 'date_format:Y-m-d', 'before:submission_start'],
            'submission_start' => ['required', 'date_format:Y-m-d', 'before:submission_deadline'],
            'submission_deadline' => ['required', 'date_format:Y-m-d'],
        ]);

        if($request->has('event_published'))    
        {
            $formFields['event_published'] = 1;
        }
        else
            {$formFields['event_published'] = 0;}

        $event->update($formFields);

        return redirect()->route('showEvent', $event->id)->with('success', 'Evento ' . $event->event_name . ' atualizado.');
    }

    //Returns event form view
    public function create()
    {
        $this->authorize('create', Event::class);

        return view('events.create');
    }

    //Store event
    public function store(Request $request)
    {
        $this->authorize('create', Event::class);
        
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

        $formFields['event_published'] = false;
        $formFields['event_status'] = 0;

        Event::create($formFields);

        $events = Event::sortable()->paginate();

        return redirect()->route('manageEvents')->with('success', 'Evento ' . $formFields['event_name'] . ' criado.');
    }

    public function destroy(Event $event)
    {
        $response = Gate::inspect('delete', Event::class);

        if($response->allowed())
        {
            $event->delete();

            return redirect()->route('manageEvents')->with('success', 'Evento ' . $event->event_name . ' removido.');
        }
        else
        {
            return redirect()->back()->with('error', $response->message());
        }
    }
}
