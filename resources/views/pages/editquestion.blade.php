@extends('layouts.app')

@section('title', $question->title)
@section('text_body', $question->text_body)


@section('content')
<section id="question">

    @if (Auth::user()->getAuthIdentifier() == $question->id_user)
    <form action ="{{ route('deletequestion', ['id' => $question->question_id]) }}" method = "POST">
        {{ csrf_field() }}
        <button type="submit" class="delete">&#10761;</button>
    </form>
    @endif

    <h2 id="title_display">
        <div>
            {{ $question->title }}
        </div>
    </h2>

    <div id="text_body_display">
        {{ $question->text_body }}
    </div>
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
    <h2>Answers</h2>
    @each('partials.answer', $answers, 'answer')
</section>
@endsection