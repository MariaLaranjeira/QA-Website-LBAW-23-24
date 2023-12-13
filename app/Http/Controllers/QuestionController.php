<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

use Illuminate\View\View;

use App\Models\Question;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\UserAnswerRating;

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

        $request->validate([
            'title' => 'required|string|min:5|max:100|unique:question',
            'text_body' => 'required|string|min:5|max:4000',
        ]);

        $question = new Question();
        $question->id_user = Auth::user()->getAuthIdentifier(); //Talvez esteja errado. Nada temas, está certo
        $question->rating = 0;
        $question->creation_date = now();
        $question->title = $request->input('title');
        $question->text_body = $request->input('text_body');
        //$question->media_address = 0; Colocar funcionalidade depois

        $question->save();

        $id = $question->question_id;

        return redirect('/question/'.$id, 302, ['question' => $question, 'id' => $id])->withSuccess('Created a question successfully.');
    }

    public function edit(Request $request,$id) {

        $question = Question::findOrFail($id);
        $this->authorize('edit', $question);

        if ($question->title == $request->input('title')) {
            $request->validate([
                'text_body' => 'required|string|min:5|max:4000',
            ]);
        }
        else {
            $request->validate([
                'title' => 'required|string|min:5|max:100',
                'text_body' => 'required|string|min:5|max:4000',
            ]);
        }
        $question->title = $request->input('title');
        $question->text_body = $request->input('text_body');
        $question->save();
        return response()->json(['message' => 'Updated the question successfully.', 'question' => $question], 200);
    }

    public function show($id) {
        $question = Question::findOrFail($id);
        $answers = Answer::query()->where('id_question', '=', $id)->orderBy('creation_date', 'desc')->get();
        $comments = Comment::query()->where('id_question', '=', $id)->orderBy('creation_date', 'desc')->get();
        return view('pages/question', [
            'question' => $question,
            'answers' => $answers,
            'comments' => $comments
        ]);
    }

    public function delete($id) {
        $question = Question::find($id);
        $this->authorize('delete', $question);

        $question->delete();

        return response()->json(['message' => 'Deleted a question successfully.'], 200);
    }



    public function search(Request $request) {

        //$this->authorize('search', Question::class);

        $request->validate([
            'search' => 'required|string|min:1',
        ]);

        $input = $request->get('search') ? $request->get('search') : "*";
        $lower = strtolower($input);
        $upper = strtoupper($input);

        $questions = Question::whereRaw("(lower(title) like ? or upper(title) like ?)", ["%$lower%", "%$upper%"])
            ->get();

        return view('pages.searchquestion',['questions' => $questions, 'search' => $input])->render();
    }

    public function upvote() {
        //TODO
    }

    public function downvote() {
        //TODO
    }
}