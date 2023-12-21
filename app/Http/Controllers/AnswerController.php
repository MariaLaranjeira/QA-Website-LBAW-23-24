<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class AnswerController extends Controller
{

    public function create(Request $request, $id) {
        $this->authorize('create', Answer::class);

        $request->validate([
            'answer_body' => 'required|string|max:4000|min:1',
        ]);

        $answer = new Answer();
        $answer->id_user = Auth::user()->getAuthIdentifier(); //Talvez esteja errado. Nada temas, está certo
        $answer->id_question = $id;
        $answer->rating = 0;
        $answer->creation_date = now();
        $answer->text_body = $request->input('answer_body');
        //$question->media_address = 0; Colocar funcionalidade depois

        $answer->save();

        //return redirect('/question/'.$id, 302, ['question' => $question, 'id' => $id])->withSuccess('Created a question successfully.');
        return response()->json(['message' => 'Posted answer successfully.'], 200);
    }

    public function edit(Request $request, $id) {
        $answer = Answer::findOrFail($id);

        $this->authorize('edit', $answer);

        $request->validate([
            'answer_body' => 'required|string|max:4000|min:1',
        ]);

        $answer->text_body = $request->input('answer_body');
        $answer->save();

        return response()->json(['message' => 'Edited answer successfully.', 'answer' => $answer], 200);
    }

    public function delete(Request $request, $id) {
        $answer = Answer::findOrFail($id);

        $this->authorize('delete', $answer);

        $answer->delete();

        return response()->json(['message' => 'Deleted answer successfully.'], 200);
    }

    public function __construct() {

    }

    public function uploadAnswerPicture(Request $request) {
        $id = $request->id;
        $answer = Answer::findOrFail($request->id);
        $question = Question::findOrFail($answer->id_question);
        if($request->file('answerPic')){
            if ($answer->media_address != 'default.jpg'){
              $deletepath = public_path().'/images/answer/'.$answer->media_address;
              File::delete($deletepath);
            }
            $filename = Str::slug(Carbon::now(), '_').'.jpg';

            $request->file('answerPic')->move(public_path('images/answer'), $filename);
            $answer->media_address = $filename;
            $answer->save();
        }

        $answer->save();
        return redirect('/question/'.$answer->id_question, 302, ['question' => $question, 'id' => $answer->id_question])->withSuccess('Uploaded Media Succesfully.');
      }

}
