<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Review;
use App\Models\Document;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Review::class => ReviewPolicy::class,
    ];

    /**
     * Verifies if user can assign reviewers
     */
    public function assignReviewer(User $user)
    {
        return ($user->hasRole('admin') || $user->id === 1 || $user->hasRole('event moderator'))
        ? Response::allow()
        : Response::deny('Você não ter permissão para escolher avaliadores.');
    }

    /**
     * Verifies if user can create reviews
     */
    public function createReview(User $user, Document $document)
    {
        return ($user->hasRole('admin') || $user->id === 1 || ($user->hasRole('reviewer') && $document->users->contains($user)))
        ? Response::allow()
        : Response::deny('Você não ter permissão para avaliar essa submissão.');
    }

    /**
     * Verifies if user can edit reviews
     */
    public function editReview(User $user, Review $review)
    {
        return ($user->hasRole('admin') || $user->id === 1 || ($user->hasRole('reviewer') && $review->user->id === $user->id))
        ? Response::allow()
        : Response::deny('Você não ter permissão para editar essa avaliação.');
    }

    /**
     * Verifies if user can view the submission table
     */
    public function reviewDashboard(User $user)
    {
        return ($user->hasRole(['admin', 'event_moderator', 'reviewer']))
        ? Response::allow()
        : Response::deny('Você não ter permissão para acessar essa página.');
    }

    /**
     * Verifies if user can view all reviews of a given document
     */
    public function indexByDocument(User $user, Document $document)
    {
        return ($user->hasRole(['admin', 'event_moderator']) || $document->submission->user->id === $user->id)
        ? Response::allow()
        : Response::deny('Você não ter permissão para acessar essa página.');
    }

    /**
     * Verifies if user can view the review of a given document
     */
    public function showReview(User $user, Review $review)
    {
        return ($user->hasRole(['admin', 'event_moderator']) ||
        ($user->hasRole('reviewer') && $review->user->id === $user->id) ||
        ($user->hasRole('user') && $review->document->submission->user->id === $user->id))
        ? Response::allow()
        : Response::deny('Você não ter permissão para ver essa avaliação.');
    }
}
