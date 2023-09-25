<?php

namespace App\Policies;

use App\Models\SubmissionType;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubmissionTypePolicy
{
    use HandlesAuthorization;
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        SubmissionType::class => SubmissionTypePolicy::class,
    ];

    /**
     * Verifies if user can manage submission types
     */
    public function accessTypes(User $user)
    {
        return ($user->hasRole('admin') || $user->id === 1)
        ? Response::allow()
        : Response::deny('Você não ter permissão para gerenciar tipos.');
    }

    public function manageTypes(User $user)
    {
        if($user->hasRole('admin') || $user->id === 1)
        {
            return true;
        }
        return false;
    }
}
