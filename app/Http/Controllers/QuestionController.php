<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

use Illuminate\View\View;

use App\Models\Question;

class QuestionController extends Controller {

    public function view(Request $request) {
        $question = Question::find($request->id); //find() nao esta definida
        $this->authorize('view', $question);

        $question->owner = $question->owner()->get();
        $question->tags = $question->tag();
        $question->comments = $question->comment()->get();
        $question->answers = $question->answer()->get();

        return view('question', ['question' => $question]);
    }
    
    public function showNewQuestionForm() {
        //$this->authorize('create', Question::class);
        return view('pages/newquestion');
    }


    public function create(Request $request) {
        $this->authorize('create', Question::class);
        $question = new Question();
        $question->id_user = Auth::user()->getAuthIdentifier(); //Talvez esteja errado
        $question->question_id = $request->question_id;
        $question->rating = 0;
        $question->creation_date = date("l, jS \of F Y h:i:s A"); //Talvez seja melhor mudar
        //$question->media_address = 0; Colocar funcionalidade depois

        if (($request->title == null) or ($request->title == "")) {
            redirect()->back()->with('error', "You cannot post a question without a title");
        }
        else $question->title = $request->title;

        if (($request->text_body == null) or ($request->text_body == "")){
            redirect()->back()->with('error', "You cannot post a question without text");
        }
        else $question->text_body = $request->text_body;

        DB::beginTransaction();
        
        $question->save();

        DB::commit();
    }

    public function edit(Request $request) {
        $question = Question::find($request->id);
        $this->authorize('edit', $question);

        $question->title = $request->title;
        $question->text_body = $request->text_body;

        DB::beginTransaction();
        
        $question->save();
        
        DB::commit();
    }

    public function upvote() {
        //TODO
    }

    public function downvote() {
        //TODO
    }
}