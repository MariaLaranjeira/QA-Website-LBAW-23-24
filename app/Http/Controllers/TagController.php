<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function list() {
        if (!Auth::check()) return redirect('/login');

        $tags = Tag::all();
        return view('pages.tags', ['tags' => $tags]);
    }

    public function edit(Request $request, $name) {
        $tag = Tag::find($name);
        //$this->authorize('edit', $tag);

        $tag->name = $request->input('name');
        $tag->save();

        return redirect()->route('tags');
    }
}