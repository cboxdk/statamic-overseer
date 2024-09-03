<?php

namespace Cboxdk\StatamicOverseer\Policies;

use Cboxdk\StatamicOverseer\Models\OverseerEvent;
use Illuminate\Auth\Access\HandlesAuthorization;

class OverseerEventPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        $user = \Statamic\Facades\User::fromUser($user);

        if ($user->hasPermission('access overseer')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny($user)
    {
        // handled by before()
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view($user, OverseerEvent $overseerEvent)
    {
        // handled by before()
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create($user)
    {
        // handled by before()
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update($user, OverseerEvent $overseerEvent)
    {
        // handled by before()
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete($user, OverseerEvent $overseerEvent)
    {
        // handled by before()
        return false;
    }
}
