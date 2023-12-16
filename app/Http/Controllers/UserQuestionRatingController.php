<?php

namespace App\Http\Controllers;

use App\Models\UserQuestionRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\Question;
use App\Models\Answer;

class UserQuestionRatingController extends Controller {

    // Status returns will follow as such:
    // 0 - No previous vote, upvoted
    // 1 - No previous vote, downvoted
    // 2 - Previous upvote, upvoted
    // 3 - Previous upvote, downvoted
    // 4 - Previous downvote, upvoted
    // 5 - Previous downvote, downvoted

    function upVote (Request $request, $id)
    {
        $question = Question::findOrFail($id);
        //$this->authorize('upVote', $question);

        $currentVote = UserQuestionRating::find(['id_user' => Auth::user()->getAuthIdentifier(), 'id_question' => $id]);

        $status = 500;

        if (!$currentVote->exists()) {
            $status = 200;
            $currentVote = new UserQuestionRating();
            $currentVote->id_user = Auth::user()->getAuthIdentifier();
            $currentVote->id_question = $id;
            $currentVote->rating = 1;
            $question->rating = $question->rating + 1;
            $currentVote->save();
            $question->save();
        } else if ($currentVote->rating == 1) {
            $status = 202;
            $question->rating = $question->rating - 1;
            $currentVote->delete();
            $question->save();
        } else if ($currentVote->rating == 0) {
            $status = 204;
            $question->rating = $question->rating + 2;
            $currentVote->rating = 1;
            $question->save();
            $currentVote->save();
        }
        return response()->json(['message' => 'Updated the question vote.'], $status);
    }

    function downVote (Request $request, $id)
    {
        $question = Question::findOrFail($id);
        //$this->authorize('downVote', $question);

        $currentVote = UserQuestionRating::find(['id_user' => Auth::user()->getAuthIdentifier(), 'id_question' => $id]);

        $status = 500;

        if (!$currentVote->exists()) {
            $status = 201;
            $currentVote = new UserQuestionRating();
            $currentVote->id_user = Auth::user()->getAuthIdentifier();
            $currentVote->id_question = $id;
            $currentVote->rating = 0;
            $question->rating = $question->rating - 1;
            $currentVote->save();
            $question->save();
        } else if ($currentVote->rating == 1) {
            $status = 203;
            $question->rating = $question->rating - 2;
            $currentVote->rating = 0;
            $question->save();
            $currentVote->save();
        } else if ($currentVote->rating == 0) {
            $status = 205;
            $question->rating = $question->rating + 1;
            $currentVote->delete();
            $question->save();
        }
        return response()->json(['message' => 'Updated the question vote.'], $status);
    }
}
