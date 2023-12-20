<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use http\Env\Request;

class TagController extends Controller {

    public function create(Request $request) {
        $this->authorize('create', Tag::class);

        $request->validate([
            'name' => 'required|unique:tag|max:255', //Mudar valor de max se necessario
        ]);

        $tag = new Tag();
        $tag->name = $request->input('name');
        $tag->save();

        return redirect()->route('home'); //TODO: Mudar para a pagina da tag
    }

    public function view(Request $request) {
        $tag = Tag::find($request->id);
        $this->authorize('view', $tag);

        $tag->questions = $tag->question()->get();

        return view('tag', ['tag' => $tag]);
    }
}