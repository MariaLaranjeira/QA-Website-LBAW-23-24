<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

use Illuminate\View\View;
use App\Models\Comment;

class CommentController extends Controller {
    public function create(Request $request) {
        $this->authorize('create', Comment::class);

        $comment = new Comment();

        $comment->id_user = Auth::user()->getAuthIdentifier(); //Talvez esteja errado

        $comment->creation_date = date("l, jS \of F Y h:i:s A"); //Talvez seja melhor mudar

        if (($request->id_question == null) and ($request->id_answer != null)) {
            $comment->id_answer = $request->id_answer;
            $comment->comment_type = 'AnswerComment';
        }
        else if (($request->id_question != null) and ($request->id_answer == null)){
            $comment->id_question = $request->id_question;
            $comment->comment_type = 'QuestionComment';
        }
        else redirect()->back()->with('error', "A comment must be either an answer or a question");

        if (($request->text_body == null) or ($request->text_body == "")){
            redirect()->back()->with('error', "You cannot post a question without text");
        }
        else $comment->text_body = $request->text_body;

        DB::beginTransaction();

        $comment->save();

        DB::commit();
    }
}