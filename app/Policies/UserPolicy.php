<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function editUser(User $user, User $target)
    {
        return $user->id === $target->id;
    }

    public function deleteProfile(User $user, User $target)
    {
        return ($user->id === $target->id) || $user->is_admin;
    }
}
