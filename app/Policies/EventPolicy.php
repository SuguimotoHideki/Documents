<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Event::class => EventPolicy::class,
    ];

    public function update(User $user, Event $event)
    {
        if($user->hasRole('event moderator') && $event->moderators->contains($user))
        {
            return true;
        }
        elseif($user->hasRole('admin') || $user->id === 1)
        {
            return true;
        }
        return false;
    }

    public function delete(User $user)
    {
        if($user->hasRole('admin') || $user->id === 1)
        {
            return true;
        }
        return false;
    }

    public function create(User $user)
    {
        if($user->hasRole('admin') || $user->id === 1)
        {
            return true;
        }
        return false;
    }

    public function dashboard(User $user)
    {
        if($user->hasRole('event moderator'))
        {
            return true;
        }
        elseif($user->hasRole('admin') || $user->id === 1)
        {
            return true;
        }
        return false;
    }
}
