<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateEventRequest;
use App\Models\User;
use App\Models\Event;
use App\Models\SubmissionType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class EventController extends Controller
{
    //Returns all events
    public function index(Request $request)
    {
        $eventQuery = Event::query();
        $searchQuery = $request->get('search');

        $events = $eventQuery->where('published', true)
        ->where(function ($query) use ($searchQuery) {
            $query->where('name', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('organizer', 'LIKE', '%' . $searchQuery . '%');
        })
        ->sortable()->paginate(15)->withQueryString();

        return view('events.index', compact('events'));
    }

    //Returns a single event
    public function show(Event $event)
    {    
        $user = Auth::user();
        $pivotData = null;

        if($event->hasUser($user))
            $pivotData = $user->events->find($event->id)->pivot;

        $event->updateStatus();

        return view('events.show', [
            'event' => $event,
            'subscription' => $pivotData
        ]);
    }    

    //Returns event management page
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        $this->authorize('dashboard', Event::class);

        if($user->hasRole('event moderator'))
        {
            $events = $user->eventsModerated()->sortable();
        }
        elseif($user->hasRole('admin'))
        {
            $events = Event::sortable();
        }
        if(!empty($request->input('search')))
        {
            $searchQuery = $request->get('search');
            
            $events = $events->where('name', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('organizer', 'LIKE', '%' . $searchQuery . '%')
            ->paginate(15)->withQueryString();
        }
        else
            $events = $events->paginate(15)->withQueryString();

        return view('events.dashboard', compact('events'));
    }

    //Returns event edit form
    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        $types = SubmissionType::all();

        return view('events.edit', [
            'event' => $event,
            'types' => $types,
        ]);
    }

    public function update(ValidateEventRequest $request, Event $event)
    {
        $this->authorize('update', $event);

        if($request->hasFile('logo'))
        {
            $fields = array_merge($request->validated(), ['logo' => $request->file('logo')->store('event_logos', 'public')]);
            $event->update($fields);
        }
        else
            $event->update($request->validated());

        $event->submissionTypes()->sync($request->validated()['submission_type']);

        return redirect()->route('showEvent', $event->id)->with('success', 'Evento ' . $event->name . ' atualizado.');
    }

    //Returns event form view
    public function create()
    {
        $this->authorize('create', Event::class);
        $types = SubmissionType::all();

        return view('events.create', [
            "types" => $types,
        ]);
    }

    //Store event
    public function store(ValidateEventRequest $request)
    {
        $this->authorize('create', Event::class);
        $event = null;
        $fields = null;
        if($request->hasFile('logo'))
        {
            $fields = array_merge($request->validated(), [
                'logo' => $request->file('logo')->store('event_logos', 'public'),
                'published' => false,
                'status' => 0
            ]);
        }
        else
        {
            $fields = array_merge($request->validated(), [
                'published' => false,
                'status' => 0
            ]);
        }
        $event = Event::create($fields);

        $event->submissionTypes()->sync($request->validated()['submission_type']);

        return redirect()->route('manageEvents')->with('success', 'Evento ' . $event->name . ' criado.');
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
