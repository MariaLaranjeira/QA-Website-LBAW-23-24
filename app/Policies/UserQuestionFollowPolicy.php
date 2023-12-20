<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\UserQuestionFollow;


class UserQuestionRatingPolicy {
    public function follow (User $user, $question) : bool {
        return true;
    }
}
