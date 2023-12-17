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

        $currentVote = UserQuestionRating::query()->
        where('id_user', '=', Auth::user()->getAuthIdentifier())->
        where('id_question', '=', $id)->
        get();

        $not_exists = $currentVote->isEmpty();
        if ($not_exists) {
            $object = new UserQuestionRating();
        } else {
            $object = $currentVote[0];
        }

        $status = 500;

        if ($not_exists) {
            $status = 200;
            $object->id_user = Auth::user()->getAuthIdentifier();
            $object->id_question = $id;
            $object->rating = 1;
            $question->rating = $question->rating + 1;
            $object->save();
            $question->save();
        } else if ($object->rating == 1) {
            $status = 202;
            $question->rating = $question->rating - 1;
            $object->delete();
            $question->save();
        } else if ($object->rating == 0) {
            $status = 204;
            $question->rating = $question->rating + 2;
            $object->rating = 1;
            $question->save();
            $object->save();
        }
        return response()->json(['message' => 'Updated the question vote.'], $status);
    }

    function downVote (Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $currentVote = UserQuestionRating::query()->
        where('id_user', '=', Auth::user()->getAuthIdentifier())->
        where('id_question', '=', $id)->
        get();

        $not_exists = $currentVote->isEmpty();
        if ($not_exists) {
            $object = new UserQuestionRating();
        } else {
            $object = $currentVote[0];
        }

        $status = 500;

        if ($not_exists) {
            $status = 201;
            $object->id_user = Auth::user()->getAuthIdentifier();
            $object->id_question = $id;
            $object->rating = 0;
            $question->rating = $question->rating - 1;
            $object->save();
            $question->save();
        } else if ($object->rating == 1) {
            $status = 203;
            $question->rating = $question->rating - 2;
            $object->rating = 0;
            $question->save();
            $object->save();
        } else if ($object->rating == 0) {
            $status = 205;
            $question->rating = $question->rating + 1;
            $object->delete();
            $question->save();
        }
        return response()->json(['message' => 'Updated the question vote.'], $status);
    }
}
