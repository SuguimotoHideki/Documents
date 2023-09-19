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
        $events = Event::where('published', true)->sortable()->paginate();
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
            'name' => ['required', 'string', Rule::unique('events', 'name')->ignore($event, 'id')],
            'website' => ['required', 'string'],
            'information' => ['required', 'string'],
            'paper_topics' => ['required', 'string'],
            'email' => ['required', 'string'],
            'organizer' => ['required', 'string'],
            'status' => ['required'],
            'organizer_email' => ['required', 'string'],
            'organizer_website' => ['required', 'string'],
            'subscription_start' => ['required', 'date_format:Y-m-d', 'before:subscription_deadline'],
            'subscription_deadline' => ['required', 'date_format:Y-m-d', 'before:submission_start'],
            'submission_start' => ['required', 'date_format:Y-m-d', 'before:submission_deadline'],
            'submission_deadline' => ['required', 'date_format:Y-m-d'],
        ]);

        if($request->has('published'))    
        {
            $formFields['published'] = 1;
        }
        else
            {$formFields['published'] = 0;}

        $event->update($formFields);

        return redirect()->route('showEvent', $event->id)->with('success', 'Evento ' . $event->name . ' atualizado.');
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
            'name' => ['required', 'string', Rule::unique('events', 'name')],
            'website' => ['required', 'string'],
            'information' => ['required', 'string'],
            'email' => ['required', 'string'],
            'submission_type' => ['required', 'array'],
            'organizer' => ['required', 'string'],
            'organizer_email' => ['required', 'string'],
            'organizer_website' => ['required', 'string'],
            'subscription_start' => ['required', 'date_format:Y-m-d', 'before:subscription_deadline'],
            'subscription_deadline' => ['required', 'date_format:Y-m-d', 'before:submission_start'],
            'submission_start' => ['required', 'date_format:Y-m-d', 'before:submission_deadline'],
            'submission_deadline' => ['required', 'date_format:Y-m-d'],
        ]);

        if($request->hasFile('logo'))
        {
            $formFields['logo'] = $request->file('logo')->store('event_logos', 'public');
        }

        $formFields['submission_type'] = implode(", ", $formFields['submission_type']);

        $formFields['published'] = false;
        $formFields['status'] = 0;

        Event::create($formFields);

        return redirect()->route('manageEvents')->with('success', 'Evento ' . $formFields['name'] . ' criado.');
    }

    public function destroy(Event $event)
    {
        $response = Gate::inspect('delete', Event::class);

        if($response->allowed())
        {
            $event->delete();

            return redirect()->route('manageEvents')->with('success', 'Evento ' . $event->name . ' removido.');
        }
        else
        {
            return redirect()->back()->with('error', $response->message());
        }
    }
}
