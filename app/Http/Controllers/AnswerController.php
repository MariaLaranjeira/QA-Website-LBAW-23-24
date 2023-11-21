<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{

    public function create(Request $request, $id) {
        //$this->authorize('create', Question::class);

        $request->validate([
            'answer_body' => 'required|string|max:4000',
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
        return redirect()->refresh();
    }

    public function __construct() {
        
    }

}



















