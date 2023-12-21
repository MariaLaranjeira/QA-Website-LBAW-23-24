<?php

namespace App\Http\Controllers;

use App\Models\QuestionTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;


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
        $tags = DB::table('tag')->get();

        return view('pages/newquestion', ['tags' => $tags]);
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

        $tags = $request->input('tags');
        if ($tags != null) {
            foreach ($tags as $tag) {
                DB::table('question_tag')->insert([
                    'id_question' => $id,
                    'id_tag' => $tag,
                ]);
            }
        }

        return redirect('/question/'.$id, 302, ['question' => $question, 'id' => $id])->withSuccess('Created a question successfully.');
    }

    public function edit(Request $request,$id) {

        $question = Question::findOrFail($id);
        $this->authorize('edit', $question);
        $tags = $request->input('tags');

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

        QuestionTag::where('id_question', '=', $id)->delete();

        if($tags != null) {
            foreach ($tags as $tag) {
                DB::table('question_tag')->insert([
                    'id_question' => $id,
                    'id_tag' => $tag,
                ]);
            }
        }


        $question->title = $request->input('title');
        $question->text_body = $request->input('text_body');
        $question->save();
        return response()->json(['message' => 'Updated the question successfully.', 'question' => $question], 200);
    }

    public function editTags(Request $request, $id) {

        $question = Question::findOrFail($id);
        $this->authorize('edit', $question);
        $tags = $request->input('tags');

        QuestionTag::where('id_question', '=', $id)->delete();

        foreach ($tags as $tag) {
            DB::table('question_tag')->insert([
                'id_question' => $id,
                'id_tag' => $tag,
            ]);
        }

        $question->save();
        return response()->json(['message' => 'Updated the question successfully.', 'question' => $question], 200);
    }

    public function show($id) {
        $question = Question::with(['comments','answers.comments','tags'])->findOrFail($id);
        $tags = Tag::all();

        //$answers = Answer::query()->where('id_question', '=', $id)->orderBy('creation_date', 'desc')->get();
        //$commentsQ = Comment::query()->where('id_question', '=', $id)->orderBy('creation_date', 'desc')->get();
        /*
        $commentsA = [];
        foreach($answers as $answer) {
            $commentsA[$answer->answer_id] = Comment::query()->where('id_answer', '=', $answer->answer_id)->orderBy('creation_date', 'desc')->get();
        }
        */
        return view('pages/question', [
            'question' => $question,
            'tags' => $tags
                //'answers' => $answers,
            //'commentsQ' => $commentsQ,
            //'commentsA' => $commentsA
        ]);
    }

    public function delete($id) {
        $question = Question::findOrFail($id);
        $this->authorize('delete', $question);

        $question->delete();

        return response()->json(['message' => 'Deleted a question successfully.'], 200);
    }

    /*PICTURE*/

    public function editQuestionPicture($id)
    {
        $question = Question::findOrFail($id);
        $this->authorize('edit', $question);
        $answers = Answer::query()->where('id_question', '=', $id)->orderBy('creation_date', 'desc')->get();
        return view('pages/editQuestionPicture', [
            'question' => $question,
            'answers' => $answers
        ]);
    }

    public function uploadQuestionPicture(Request $request) {
        $id = $request->id;
        $question = Question::findOrFail($request->id);
        if($request->file('questionPic')){
            if ($question->media_address != 'default.jpg'){
              $deletepath = public_path().'/images/question/'.$question->media_address;
              File::delete($deletepath);
            }
            $filename = Str::slug(Carbon::now(), '_').'.jpg';

            $request->file('questionPic')->move(public_path('images/question'), $filename);
            $question->media_address = $filename;
            $question->save();
        }

        $question->save();
        return redirect('/question/'.$id, 302, ['question' => $question, 'id' => $id])->withSuccess('Uploaded Media Succesfully.');
      }




    public function search(Request $request) {

        //$this->authorize('search', Question::class);

        $request->validate([
            'search' => 'required|string|min:1',
        ]);

        $query = Question::query();

        // Basic search term
        if ($searchTerm = $request->input('search')) {
            $query->whereRaw("ts_search @@ plainto_tsquery('english', ?)", [$searchTerm]);
        }

        // Date range filter
        if ($startDate = $request->input('start_date')) {
            $query->where('creation_date', '>=', $startDate);
        }
        if ($endDate = $request->input('end_date')) {
            $query->where('creation_date', '<=', $endDate);
        }

        // Rating filter
        if ($minRating = $request->input('min_rating')) {
            $query->where('rating', '>=', $minRating);
        }

        $questions = $query->get();

        return view('pages.searchquestion',['questions' => $questions, 'search' => $searchTerm])->render();
    }

    public function markBestAnswer($answer_id) {
        $answer = Answer::findOrFail($answer_id);
        $question = Question::findOrFail($answer->id_question);

        $this->authorize('markBestAnswer', $question);

        $question->id_best_answer = $answer_id;
        $question->save();

        return redirect()->route('question', ['id' => $answer->id_question]);
    }

    public function deleteBestAnswer($answer_id){
        $answer = Answer::findOrFail($answer_id);
        $question = Question::findOrFail($answer->id_question);

        $this->authorize('deleteBestAnswer', $question);

        $question->id_best_answer = null;
        $question->save();

        return redirect()->route('question', ['id' => $answer->id_question]);
    }
}
