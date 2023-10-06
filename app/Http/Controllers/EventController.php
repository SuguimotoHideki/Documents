<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\SubmissionType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\QueryException;
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

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $formFields = $request->validate([
            'name' => ['required', 'string', Rule::unique('events', 'name')->ignore($event, 'id')],
            'website' => ['required', 'string'],
            'information' => ['required', 'string'],
            'email' => ['required', 'string'],
            'submission_type' => ['required', 'array'],
            'published' => ['required'],
            'organizer' => ['required', 'string'],
            'organizer_email' => ['required', 'string'],
            'organizer_website' => ['required', 'string'],
            'subscription_start' => ['required', 'date_format:Y-m-d', 'before:subscription_deadline'],
            'subscription_deadline' => ['required', 'date_format:Y-m-d', 'before:submission_start'],
            'submission_start' => ['required', 'date_format:Y-m-d', 'before:submission_deadline'],
            'submission_deadline' => ['required', 'date_format:Y-m-d'],
        ]);

        if($request->hasFile('logo'))
            $formFields['logo'] = $request->file('logo')->store('event_logos', 'public');

        $formFields['subscription_start'] = Carbon::createFromFormat('Y-m-d H:i:s', $formFields['subscription_start'] . ' ' . "00:00:00");
        $formFields['subscription_deadline'] = Carbon::createFromFormat('Y-m-d H:i:s', $formFields['subscription_deadline'] . ' ' . "23:59:59");
        $formFields['submission_start'] = Carbon::createFromFormat('Y-m-d H:i:s', $formFields['submission_start'] . ' ' . "00:00:00");
        $formFields['submission_deadline'] = Carbon::createFromFormat('Y-m-d H:i:s', $formFields['submission_deadline'] . ' ' . "23:59:59");

        $event->update($formFields);

        $event->submissionTypes()->sync($formFields['submission_type']);

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

        $formFields['published'] = false;
        $formFields['status'] = 0;

        $formFields['subscription_start'] = Carbon::createFromFormat('Y-m-d H:i:s', $formFields['subscription_start'] . ' ' . "00:00:00");
        $formFields['subscription_deadline'] = Carbon::createFromFormat('Y-m-d H:i:s', $formFields['subscription_deadline'] . ' ' . "23:59:59");
        $formFields['submission_start'] = Carbon::createFromFormat('Y-m-d H:i:s', $formFields['submission_start'] . ' ' . "00:00:00");
        $formFields['submission_deadline'] = Carbon::createFromFormat('Y-m-d H:i:s', $formFields['submission_deadline'] . ' ' . "23:59:59");

        $event = Event::create($formFields);
        $event->submissionTypes()->sync($formFields['submission_type']);

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
