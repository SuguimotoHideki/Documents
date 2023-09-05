<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Document;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;
class DocumentPolicy
{
    use HandlesAuthorization;
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Document::class => DocumentPolicy::class,
    ];

    public function assignReviewer(User $user)
    {
        return ($user->hasRole('admin') || $user->id === 1 || $user->hasRole('event moderator'))
        ? Response::allow()
        : Response::deny('Você não ter permissão para escolher avaliadores.');
    }

    public function createReview(User $user, Document $document)
    {
        return ($user->hasRole('admin') || $user->id === 1 || ($user->hasRole('event moderator') && $document->users->contains($user)))
        ? Response::allow()
        : Response::deny('Você não ter permissão para avaliar essa submissão.');
    }

    public function editReview(User $user, Document $document)
    {
        return ($user->hasRole('admin') || $user->id === 1 || ($user->hasRole('event moderator') && $document->users->contains($user)))
        ? Response::allow()
        : Response::deny('Você não ter permissão para editar essa avaliação.');
    }
}
