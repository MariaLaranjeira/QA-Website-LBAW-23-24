<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\UserTagFollow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserTagFollowController extends Controller
{
    // Status returns will follow as such:
    // 0 - Followed
    // 1 - Unfollowed

    public function follow(Request $request, $name)
    {
        $tag = Tag::findOrFail($name);
        //$this->authorize('follow', $question);
        $currentFollow = UserTagFollow::query()->
        where('id_user', '=', Auth::user()->getAuthIdentifier())->
        where('id_tag', '=', $name)->get();
        if (!$currentFollow->isEmpty()) {
            $status = 201;
            $currentFollow->first()->delete();
        } else {
            $status = 200;
            $object = new UserTagFollow();
            $object->id_user = Auth::user()->getAuthIdentifier();
            $object->id_tag = $name;
            $object->save();
        }
        return response()->json(['message' => 'Updated tag follow status.'], $status);
    }

}