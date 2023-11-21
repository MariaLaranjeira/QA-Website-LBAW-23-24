@extends('layouts.app')

@section('title', $question->title)
@section('text_body', $question->text_body)


@section('content')
<section id="question">

    <h2 id="title_display">
        <div>
            {{ $question->title }}
        </div>
    </h2>

    <div id="text_body_display">
        {{ $question->text_body }}
    </div>

    <h2>Post your answer</h2>
        <form action="{{ route('newanswer', ['id' => $question->question_id]) }}" method="POST">
            {{ csrf_field() }}
            <input type="text">
            <button type="submit">
                Post New Answer
            </button>
        </form>
    <h2>Answers</h2>
        @each('partials.answer', $answers, 'answer')
</section>
@endsection