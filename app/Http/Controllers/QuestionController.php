<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

use Illuminate\View\View;

use App\Models\Question;
use App\Models\Answer;

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
        //$this->authorize('create', Question::class);

        $request->validate([
            'title' => 'required|string|max:100|unique:question',
            'text_body' => 'required|string|max:4000',
        ]);

        $question = new Question();
        $question->id_user = Auth::user()->getAuthIdentifier(); //Talvez esteja errado. Nada temas, está certo
        $question->rating = 0;
        $question->creation_date = now();
        $question->title = $request->input('title');
        $question->text_body = $request->input('text_body');
        //$question->media_address = 0; Colocar funcionalidade depois

        $question->save();

        return redirect('/home')->withSuccess('Created a question successfully.');
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

    public function show($id) {

        $question = Question::findOrFail($id);
        $answers = Answer::query()->where('id_question', '=', $id)->orderBy('rating')->get();

        //$this->authorize('show', $question);

        return view('pages/question', [
            'question' => $question,
            'answers' => $answers
        ]);
    }

    public function upvote() {
        //TODO
    }

    public function downvote() {
        //TODO
    }
}