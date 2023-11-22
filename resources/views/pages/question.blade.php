@extends('layouts.app')

@section('title', $question->title)
@section('text_body', $question->text_body)


@section('content')
<section id="question">

    @if (Auth::user()->getAuthIdentifier() == $question->id_user)
        <form action ="{{ route('deletequestion', ['id' => $question->question_id]) }}" method = "POST">
            {{ csrf_field() }}
            <button type="submit" class="delete">Delete this question</button>
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

    <div id="post_info">
        <div id="author">
            Author: Implementar isto
        </div>
        <div id="date">
            Posted on: {{ $question->creation_date }}
        </div>
</section>

<section id="question_answers">
    @if (Auth::user()->getAuthIdentifier() != $question->id_user)
    <h2>Post your answer</h2>
        <form action="{{ route('newanswer', ['id' => $question->question_id]) }}" method="POST">
            {{ csrf_field() }}
            <textarea type="text" name="answer_body" id="answer_body" placeholder="Write your answer here (Be respectful)"></textarea>
            <button type="submit">
                Post New Answer
            </button>
        </form>
    @endif
    <h2>Answers</h2>
    @each('partials.answer', $answers, 'answer')
</section>
@endsection