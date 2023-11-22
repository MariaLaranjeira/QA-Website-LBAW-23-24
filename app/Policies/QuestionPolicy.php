<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;


class QuestionPolicy {
    /**
     * Create a new policy instance.
     */
    public function __construct() {
        //
    }

    /**
     * Determine if all questions can be listed by a user.
     */
    public function list(User $user): bool {
        // Any (authenticated) user can list its own questions.
        return Auth::check();
    }

    /**
     * Determine if a question can be created by a user.
     */
    public function create(): bool {
        // Any user can create a new question.
        return Auth::check();
    }

    /**
     * Determine if a question can be deleted by a user.
     */
    public function delete(User $user, Question $question): bool {
        // Only a question owner can delete it.
        return $user->user_id === $question->id_user|| $user->is_admin;
    }

    public function edit(User $user, Question $question): bool
    {
        // User can only update items in cards they own.
        return $user->user_id === $question->id_user || $user->is_admin;
    }


}