<?php

namespace App\Policies;

use App\Models\Admin;
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
        return ($user->id === $target->id) || Admin::where('user_id', $user->user_id)->exists();
    }
}
