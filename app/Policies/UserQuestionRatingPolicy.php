<?php


namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\UserQuestionRating;


class UserQuestionRatingPolicy {
    public function upVote ($question) : bool {
        return Auth::check() && $question->id_user != Auth::user()->getAuthIdentifier();
    }

    public function downVote ($question) : bool {
        return Auth::check() && $question->id_user != Auth::user()->getAuthIdentifier();
    }
}
