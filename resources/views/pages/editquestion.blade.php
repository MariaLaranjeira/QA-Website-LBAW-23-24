@extends('layouts.app')

@section('title', $question->title)
@section('text_body', $question->text_body)


@section('content')
<section id="question">

    <form method = "POST" action = "{{ route('editingquestion', ['id' => $question->question_id]) }}" >
        {{ csrf_field() }}
        <h2 id="edit_title_display">
            <textarea type="text" name="title" id="title">
                {{ $question->title }}
            </textarea>
        </h2>

        <h2 id="edit_text_body">
            <textarea type="text" name="text_body" id="text_body">
                {{ $question->text_body }}
            </textarea>
        </h2>
        <button type="submit">
            Apply
        </button>
    </form>

    @if (Auth::user()->getAuthIdentifier() != $question->id_user)
        <h2>Post your answer</h2>
        <form action="{{ route('newanswer', ['id' => $question->question_id]) }}" method="POST">
            {{ csrf_field() }}
            <input type="text" name="answer_body" id="answer_body">
            <button type="submit">
                Post New Answer
            </button>
        </form>
    @endif
</section>
@endsection