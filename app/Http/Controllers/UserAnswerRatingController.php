<?php

namespace App\Http\Controllers;

use App\Models\UserAnswerRating;
use App\Models\UserQuestionRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Answer;

class UserAnswerRatingController extends Controller {

    // Status returns will follow as such:
    // 0 - No previous vote, upvoted
    // 1 - No previous vote, downvoted
    // 2 - Previous upvote, upvoted
    // 3 - Previous upvote, downvoted
    // 4 - Previous downvote, upvoted
    // 5 - Previous downvote, downvoted

    function upVote (Request $request, $id)
    {
        $answer = Answer::findOrFail($id);

        $currentVote = UserAnswerRating::query()->
        where('id_user', '=', Auth::user()->getAuthIdentifier())->
        where('id_answer', '=', $id)->
        get();

        $not_exists = $currentVote->isEmpty();
        if ($not_exists) {
            $object = new UserAnswerRating();
        } else {
            $object = $currentVote[0];
        }

        $status = 500;

        if ($not_exists) {
            $status = 200;
            $object->id_user = Auth::user()->getAuthIdentifier();
            $object->id_answer = $id;
            $object->rating = 1;
            $answer->rating = $answer->rating + 1;
            $object->save();
            $answer->save();
        } else if ($object->rating == 1) {
            $status = 202;
            $answer->rating = $answer->rating - 1;
            $object->delete();
            $answer->save();
        } else if ($object->rating == 0) {
            $status = 204;
            $answer->rating = $answer->rating + 2;
            $object->rating = 1;
            $answer->save();
            $object->save();
        }
        return response()->json(['message' => 'Updated the question vote.'], $status);
    }

    function downVote (Request $request, $id)
    {
        $answer = Answer::findOrFail($id);

        $currentVote = UserAnswerRating::query()->
        where('id_user', '=', Auth::user()->getAuthIdentifier())->
        where('id_answer', '=', $id)->
        get();

        $not_exists = $currentVote->isEmpty();
        if ($not_exists) {
            $object = new UserAnswerRating();
        } else {
            $object = $currentVote[0];
        }

        $status = 500;

        if ($not_exists) {
            $status = 201;
            $object->id_user = Auth::user()->getAuthIdentifier();
            $object->id_answer = $id;
            $object->rating = 0;
            $answer->rating = $answer->rating - 1;
            $object->save();
            $answer->save();
        } else if ($object->rating == 1) {
            $status = 203;
            $answer->rating = $answer->rating - 2;
            $object->rating = 0;
            $answer->save();
            $object->save();
        } else if ($object->rating == 0) {
            $status = 205;
            $answer->rating = $answer->rating + 1;
            $object->delete();
            $answer->save();
        }
        return response()->json(['message' => 'Updated the question vote.'], $status);
    }
}
