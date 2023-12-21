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

        return redirect()->route('tags');
    }

    public function view(Request $request) {
        $tag = Tag::find($request->id);

        $tag->questions = $tag->question()->get();

        return view('tag', ['tag' => $tag]);
    }

    public function list() {
        $tags = Tag::all()->sortBy('name');
        return view('pages.tags', ['tags' => $tags]);
    }

    public function edit(Request $request, $name) {
        $tag = Tag::find($name);
        $this->authorize('edit', $tag);

        $tag->name = $request->input('name');
        $tag->save();

        return redirect()->route('tags');
    }

    public function delete($name) {
        $tag = Tag::find($name);
        $this->authorize('delete', $tag);

        $tag->delete();

        return redirect()->route('tags');
    }

    public function show($id) {
        $tag = Tag::with('questions')->limit(10)->findOrFail($id);
        //$this->authorize('view', $tag);
        return view('pages/tag', [
            'tag' => $tag
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
        ]);

        if ($request->input('search') == '') {
            $tags = Tag::all()->limit(10);
        } else {
            $searchTerm = $request->input('search');
            $tags = Tag::whereRaw("ts_search @@ plainto_tsquery('english', ?)", [$searchTerm])->get();
        }
        return view('pages.tags',['tags' => $tags, 'search_tags' => $searchTerm])->render();
    }

    public function searchQuestions(Request $request, $name)
    {
        $tag = Tag::find($name);
        $request->validate([
            'search' => 'required|string',
        ]);

        if ($request->input('search') == '') {
            $questions = $tag->questions()->limit(10)->get();
        } else {
            $searchTerm = $request->input('search');
            $questions = $tag->questions()->whereRaw("ts_search @@ plainto_tsquery('english', ?)", [$searchTerm])->get();
            $tag->questions = $questions;
        }
        return view('pages.tag',['tag' => $tag, 'search_question' => $searchTerm])->render();
    }
}