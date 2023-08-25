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
        return view('events.show', [
            'event' => $event
        ]);
    }    

    //Returns events subscribed by the user
    public function subscribedEvents(Request $request, User $user)
    {
        $column = $request['sort'];
        $direction = $request['direction'];

        if($column !== null && $direction !== null)
        {
            $subscribedEvents = $user->events()->orderBy($column, $direction)->paginate();
        }
        else
        {
            $subscribedEvents = $user->events()->sortable()->paginate();
        }
        
        return view('events.indexSubscribed', [
            'events' => $subscribedEvents,
            'user' => $user
        ]);
    }

    public function subscribedUsers(Event $event, Request $request)
    {
        $column = $request['sort'];
        $direction = $request['direction'];

        if($column !== null && $direction !== null)
        {
            $subscribers = $event->users()->orderBy($column, $direction)->paginate();
        }
        else
        {
            $subscribers = $event->users()->sortable()->paginate();
        }

        return view('events.indexSubscribers', [
            'event' => $event,
            'users' => $subscribers
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

    public function subscribe(Event $event)
    {
        $user = Auth::user();
        try
        {
            $event->users()->attach($user->id, ['created_at' => now(), 'updated_at' => now()]);

            return redirect()->route('indexSubscribedEvents', ['user' => $user])->with('message', 'Inscrito no evento ' . $event->event_name . '.');
        }
        catch(QueryException $error)
        {
            if($error->getCode() === '23000')
            {
                return redirect()->back()->with('error', 'Você já está inscrito no evento ' . $event->event_name . '.');
            }
            else {
                // Other database-related error occurred
                return redirect()->back()->with('error', 'Ocorreu um erro ao se inscrever no evento.');
            }
        }
    }

    public function cancelSubscription(Request $request)
    {
        $event = Event::find($request['event']);

        $event->users()->detach($request['user']);

        return redirect()->back()->with('message', 'Inscrição removida.');
    }

    public function eventModerator(Event $event)
    {
        $users = User::role('event moderator')->where('id', '!=', 1)->get();
        return view('events.createModerator',[
            'event' => $event,
            'users' => $users
        ]);
    }

    public function addModerator(Request $request, Event $event)
    {
        $parameters = $request['permissions'];
        foreach($parameters as $userId => $permissions)
        {
            $user = User::find($userId);
            if($permissions[0] === '1')
            {
                if(!$event->moderators->contains($user))
                {
                    $event->moderators()->attach($user->id, ['created_at' => now(), 'updated_at' => now()]);
                }
            }
            else
            {
                $event->moderators()->detach($user->id);
            }
        }
        return back()->with('message', 'Permissões aplicadas.');
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

        //return redirect()->route('showEvent', [$event])->with('message', 'Event update successful');
        return redirect()->route('showEvent', $event->id)->with('message', 'Evento ' . $event->event_name . ' atualizado.');
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
        return redirect('/')->with('message', 'Evento ' . $formFields['event_name'] . ' criado.');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', Event::class);

        $event->delete();

        return redirect('/')->with('message', 'Evento ' . $event->event_name . ' removido.');
    }
}
