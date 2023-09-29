<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\QueryException;

class SubscriptionController extends Controller
{
    //Returns events subscribed by the user
    public function indexSubscribed(Request $request, User $user)
    {
        $this->authorize('indexSubscribed', [Event::class, $user]);

        $column = $request['sort'];
        $direction = $request['direction'];

        if($column !== null && $direction !== null)
        {
            $subscribedEvents = $user->events()->orderBy($column, $direction)->paginate(15);
        }
        else
        {
            $subscribedEvents = $user->events()->sortable()->paginate(15);
        }
        
        return view('events.indexSubscribed', [
            'events' => $subscribedEvents,
            'user' => $user
        ]);
    }

    //Returns users subscribed to the event
    public function indexSubscribers(Request $request, Event $event)
    {
        $this->authorize('indexSubscribers', $event);

        $column = $request['sort'];
        $direction = $request['direction'];

        if($column !== null && $direction !== null)
        {
            $subscribers = $event->users()->orderBy($column, $direction)->paginate(15);
        }
        else
        {
            $subscribers = $event->users()->sortable()->paginate(15);
        }

        return view('events.indexSubscribers', [
            'event' => $event,
            'users' => $subscribers
        ]);
    }
    
    public function create(Event $event)
    {
        $response = Gate::inspect('Subscribe', Event::class);

        if($response->allowed())
        {
            $user = Auth::user();
            try
            {
                $event->users()->attach($user->id, ['created_at' => now(), 'updated_at' => now()]);
    
                return redirect()->route('indexSubscribed', ['user' => $user])->with('success', 'Inscrito no evento ' . $event->name . '.');
            }
            catch(QueryException $error)
            {
                if($error->getCode() === '23000')
                {
                    return redirect()->back()->with('error', 'Você já está inscrito no evento ' . $event->name . '.');
                }
                else {
                    // Other database-related error occurred
                    return redirect()->back()->with('error', 'Ocorreu um erro ao se inscrever no evento.');
                }
            }
        }
        else
        {
            return redirect()->back()->with('error', $response->message());
        }
    }

    public function delete(Request $request)
    {
        $response = Gate::inspect('deleteSubscription', Event::find($request['event']));
        if($response->allowed())
        {
            $event = Event::find($request['event']);
            $event->users()->detach($request['user']);
            return redirect()->back()->with('success', 'Inscrição removida.');
        }
        else
        {
            return redirect()->back()->with('error', $response->message());
        }
    }
}