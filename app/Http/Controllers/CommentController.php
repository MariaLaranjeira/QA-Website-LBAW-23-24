<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Models\Comment;

class CommentController extends Controller {


    public function createComment(Request $request, $id, $type) {
        //$this->authorize('create', Comment::class);

        $comment = new Comment();

        $request->validate([
            'comment_body' => 'required|string|max:4000|min:1'
        ]);

        $comment->id_user = Auth::user()->getAuthIdentifier();

        $comment->creation_date = now();

        if($type == 'QuestionComment'){
            $comment->id_question = $id;
            $comment->comment_type = 'QuestionComment';
        }
        else if($type == 'AnswerComment'){
            $comment->id_answer = $id;
            $comment->comment_type = 'AnswerComment';
        }
        else redirect()->back()->with('error', "A comment must be either an answer or a question");

        $comment->text_body = $request->input('comment_body');
        $comment->save();

        return response()->json(['message' => 'Posted comment successfully.'], 200);
    }

    public function __construct() {

    }
}