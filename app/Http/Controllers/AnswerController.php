<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        //$this->authorize('edit', Answer::class);

        $request->validate([
            'answer_body' => 'required|string|max:4000|min:1',
        ]);

        $answer = Answer::findOrFail($id);
        $answer->text_body = $request->input('answer_body');
        $answer->save();

        return response()->json(['message' => 'Edited answer successfully.', 'answer' => $answer], 200);
    }

    public function delete(Request $request, $id) {
        $this->authorize('delete', Answer::class);

        $answer = Answer::find($id);
        $answer->delete();

        return response()->json(['message' => 'Deleted answer successfully.'], 200);
    }

    public function __construct() {
        
    }

}



















