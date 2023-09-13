<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;
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

    /**
     * Verifies if user can view a given document
     */
    public function showDocument(User $user, Document $document)
    {
        return ($user->hasRole(['admin', 'event moderator']) ||
        ($user->hasRole('reviewer') && $document->users->contains($user)) ||
        ($user->hasRole('user') && $document->submission->user->id === $user->id))
        ? Response::allow()
        : Response::deny('Você não ter permissão para ver essa submissão.');
    }

    /**
     * Verifies if user can edit a given document
     */
    public function editDocument(User $user, Document $document)
    {
        return ($user->hasRole(['admin', 'event moderator']) ||
        ($user->hasRole('user') && $document->submission->user->id === $user->id))
        ? Response::allow()
        : Response::deny('Você não ter permissão para editar essa submissão.');
    }

    /**
     * Verifies if user can delete a given document
     */
    public function deleteDocument(User $user, Document $document)
    {
        return ($user->hasRole(['admin', 'event moderator']) ||
        ($user->hasRole('user') && $document->submission->user->id === $user->id))
        ? Response::allow()
        : Response::deny('Você não ter permissão para deletar essa submissão.');
    }

    /**
     * Verifies if user can create a submission
     */
    public function createDocument(User $user, Event $event)
    {
        if($user->hasRole(['admin', 'event moderator']))
        {
            return Response::allow();
        }
        elseif(($user->hasRole('user') && $event->users->contains($user)))
        {
            if($event->userSubmission($user) === null)
            {
                return Response::allow();
            }
            else
            {
                return Response::deny("Você já fez uma submissão nesse evento.");
            }
        }
        else
        {
            return Response::deny("Você precisa estar inscrito para enviar submissões.");
        }
    }

    /**
     * Verifies if user can access the document's dashboard table
     */
    public function indexDocument(User $user)
    {
        return ($user->hasRole(['admin', 'event moderator', 'reviewer']))
        ? Response::allow()
        : Response::deny('Você não ter permissão para acessar essa página.');
    }
}
