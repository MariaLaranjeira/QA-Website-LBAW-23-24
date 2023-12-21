<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller {

    public function create(Request $request) {
        //$this->authorize('create', Tag::class);

        $request->validate([
            'name' => 'required|unique:tag|max:255', //Mudar valor de max se necessario
        ]);

        $tag = new Tag();
        $tag->name = $request->input('name');
        $tag->save();

        return redirect()->route('tags');
    }

    public function view(Request $request) {
        $tag = Tag::find($request->id);
        $this->authorize('view', $tag);

        $tag->questions = $tag->question()->get();

        return view('tag', ['tag' => $tag]);
    }

    public function list() {
        if (!Auth::check()) return redirect('/login');

        $tags = Tag::all()->sortBy('name');
        return view('pages.tags', ['tags' => $tags]);
    }

    public function edit(Request $request, $name) {
        $tag = Tag::find($name);
        //$this->authorize('edit', $tag);

        $tag->name = $request->input('name');
        $tag->save();

        return redirect()->route('tags');
    }

    public function delete($name) {
        $tag = Tag::find($name);
        //$this->authorize('delete', $tag);

        $tag->delete();

        return redirect()->route('tags');
    }

    public function show($id) {
        $tag = Tag::with('questions')->findOrFail($id);
        //$this->authorize('view', $tag);
        return view('pages/tag', [
            'tag' => $tag
        ]);
    }
}