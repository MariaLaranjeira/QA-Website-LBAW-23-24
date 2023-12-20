<?php

namespace App\Http\Controllers;

use App\Models\UserQuestionFollow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\Question;
use App\Models\Answer;

class UserQuestionFollowController extends Controller
{
    // Status returns will follow as such:
    // 0 - Followed
    // 1 - Unfollowed

    public function follow(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        //$this->authorize('follow', $question);
        $currentFollow = UserQuestionFollow::query()->
        where('id_user', '=', Auth::user()->getAuthIdentifier())->
        where('id_question', '=', $id)->get();
        if (!$currentFollow->isEmpty()) {
            $status = 201;
            $currentFollow->first()->delete();
        } else {
            $status = 200;
            $object = new UserQuestionFollow();
            $object->id_user = Auth::user()->getAuthIdentifier();
            $object->id_question = $id;
            $object->save();
        }
        return response()->json(['message' => 'Updated question follow status.'], $status);
    }

}