@extends('layouts.app')

@section('title', $question->title)
@section('text_body', $question->text_body)


@section('content')
<section id="question">

    <form method = "POST" action = "{{ route('editingquestion', ['id' => $question->question_id]) }}" >
        {{ csrf_field() }}
        <h2 id="edit_title_display">
            <input type="text" name="title" id="title" value="{{ $question->title }}"></input>
            @if ($errors->has('title'))
            <span class="error">
                Your title must be between 5 and 100 characters long.
            </span>
            <br>
            @endif
        </h2>

        <h2 id="edit_text_body">
            <input type="text" name="text_body" id="text_body" value="{{ $question->text_body }}"></input>
            @if ($errors->has('text_body'))
            <span class="error">
                Your text body must be between 5 and 4000 characters long.
            </span>
            <br>
            @endif
        </h2>
        <button type="submit">
            Apply
        </button>
    </form>
</section>
@endsection