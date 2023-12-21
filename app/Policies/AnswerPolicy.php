<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Answer;
use App\Models\Moderator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AnswerPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(): bool
    {
        return Auth::check();
    }

    public function edit(User $user, Answer $answer): bool
    {
        return $user->user_id === $answer->id_user || Admin::where('admin_id', $user->user_id)->exists() || Moderator::where('mod_id', $user->user_id)->exists();
    }

    public function delete(User $user, Answer $answer): bool {
        return $user->user_id === $answer->id_user|| Admin::where('admin_id', $user->user_id)->exists();
    }


}
