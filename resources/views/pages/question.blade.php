@extends('layouts.app')

@section('title', $question->title)
@section('text_body', $question->text_body)


@section('content')
<section id="question">
    @auth
        @if (Auth::user()->getAuthIdentifier() == $question->id_user || \App\Models\User::where('user_id', Auth::user()->getAuthIdentifier())->first()->is_admin)
            <form action ="{{ route('deletequestion', ['id' => $question->question_id]) }}" method = "POST">
                {{ csrf_field() }}
                <button type="submit" class="delete">&#10761;</button>
            </form>

            <form action ="{{ route('editquestion', ['id' => $question->question_id]) }}" method = "GET">
                {{ csrf_field() }}
                <button type="submit" class="edit">&#9998;</button>
            </form>
        @endif
    @endauth

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
            {{ \App\Models\User::where('user_id', $question->id_user)->first()->username }}
        </div>
        <div id="date">
            Posted on: {{ $question->creation_date }}
        </div>
</section>

<section id="question_answers">
    @auth
        @if (Auth::user()->getAuthIdentifier() != $question->id_user)
        <h2>Post your answer</h2>
            <form action="{{ route('newanswer', ['id' => $question->question_id]) }}" method="POST">
                {{ csrf_field() }}
                <textarea type="text" name="answer_body" id="answer_body" placeholder="Write your answer here (Be respectful)"></textarea>
                    @if ($errors->has('answer_body'))
                    <span class="error">
                      Your answer's body must be between 1 and 4000 characters long.
                    </span>
                    <br>
                    @endif
                <button type="submit">
                    Post New Answer
                </button>
            </form>
        @endif
    @endauth
    <h2>Answers</h2>
    @each('partials.answer', $answers, 'answer')
</section>
@endsection