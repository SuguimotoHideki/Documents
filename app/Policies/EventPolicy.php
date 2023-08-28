<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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
        return($user->hasRole('admin') || $user->id === 1)
        ? Response::allow()
        : Response::deny('Você não ter permissão para apagar eventos.');
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

    public function indexSubscribed(User $user, User $requestedUser)
    {
        if($user->can('events.manage') || Auth::user()->id === $requestedUser->id)
        {
            return true;
        }
        return false;
    }

    public function indexSubscribers(User $user, Event $event)
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

    public function deleteSubscription(User $user)
    {
        return ($user->hasRole('admin') || $user->id === 1)
        ? Response::allow()
        : Response::deny('Você não ter permissão para cancelar inscrições.');
    }

    public function Subscribe(User $user)
    {
        return $user->can('events.subscribe')
        ? Response::allow()
        : Response::deny('Você não ter permissão para se inscrever.');
    }
}
