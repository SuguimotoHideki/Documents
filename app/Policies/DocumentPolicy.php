<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Review;
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
        return ($user->hasRole('admin') || $user->id === 1 || ($user->hasRole('reviewer') && $document->users->contains($user)))
        ? Response::allow()
        : Response::deny('Você não ter permissão para avaliar essa submissão.');
    }

    public function editReview(User $user, Review $review)
    {
        return ($user->hasRole('admin') || $user->id === 1 || ($user->hasRole('reviewer') && $review->user->id === $user->id))
        ? Response::allow()
        : Response::deny('Você não ter permissão para editar essa avaliação.');
    }

    public function reviewDashboard(User $user)
    {
        return ($user->hasRole(['admin', 'event_moderator', 'reviewer']))
        ? Response::allow()
        : Response::deny('Você não ter permissão para acessar essa página.');
    }

    public function indexByDocument(User $user, Document $document)
    {
        return ($user->hasRole(['admin', 'event_moderator']) || $document->submission->user->id === $user->id)
        ? Response::allow()
        : Response::deny('Você não ter permissão para acessar essa página.');
    }

    public function viewReview(User $user, Review $review)
    {
        return ($user->hasRole(['admin', 'event_moderator']) ||
        ($user->hasRole('reviewer') && $review->user->id === $user->id) ||
        ($user->hasRole('user') && $review->document->submission->user->id === $user->id))
        ? Response::allow()
        : Response::deny('Você não ter permissão para ver essa avaliação.');
    }

    public function viewDocument(User $user, Review $document)
    {
        return ($user->hasRole(['admin', 'event_moderator', 'reviewer']) ||
        ($user->hasRole('reviewer') && $review->user->id === $user->id) ||
        ($user->hasRole('user') && $review->document->submission->user->id === $user->id))
        ? Response::allow()
        : Response::deny('Você não ter permissão para ver essa avaliação.');
    }
}
