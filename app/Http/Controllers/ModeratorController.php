<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;

class ModeratorController extends Controller
{
    public function create(Event $event)
    {
        $this->authorize('manageModerator', Event::class);

        $users = User::role('event moderator')->where('id', '!=', 1)->get();
        return view('events.createModerator',[
            'event' => $event,
            'users' => $users
        ]);
    }

    public function store(Request $request, Event $event)
    {
        $this->authorize('manageModerator', Event::class);

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
        return back()->with('success', 'Permissões aplicadas.');
    }
}
