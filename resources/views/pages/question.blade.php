@extends('layouts.app')

@section('title', $question->title)
@section('text_body', $question->text_body)

@section('styles')
<link href="{{ url('css/question.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script type="text/javascript" src={{ url('js/questionPage.js') }} defer> </script>
@endsection

@section('content')
<section id="question">
    @auth
        @if (Auth::user()->getAuthIdentifier() == $question->id_user || \App\Models\User::where('user_id', Auth::user()->getAuthIdentifier())->first()->is_admin)
            <form action ="{{ route('deletequestion', ['id' => $question->question_id]) }}" method = "POST">
                {{ csrf_field() }}
                <button type="submit" class="delete">&#10761;</button>
            </form>

            <button type="submit" class="edit" id="question_edit_button">&#9998;</button>
        @endif
    @endauth
    <h2 id="title_display">
        <div id="question_title">
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

<section id="editMode" style="display: none">

    <form method = "POST" action = "{{ route('editingquestion', ['id' => $question->question_id]) }}" >
        {{ csrf_field() }}
        <h2 id="edit_title_display">
            <input type="text" name="title" id="question_title_edit" value="{{ $question->title }}"></input>
            @if ($errors->has('title'))
            <span class="error">
                Your title must be between 5 and 100 characters long.
            </span>
            <br>
            @endif
        </h2>

        <h2 id="edit_text_body">
            <input type="text" name="text_body" id="question_text_body_edit" value="{{ $question->text_body }}"></input>
            @if ($errors->has('text_body'))
            <span class="error">
                Your text body must be between 5 and 4000 characters long.
            </span>
            <br>
            @endif
        </h2>
        <button type="reset" id="cancelButton">
            Cancel
        </button>
        <button type="submit" id="applyButton">
            Apply
        </button>
    </form>
</section>

<section id="question_comments">
    @auth
    @if (Auth::user()->getAuthIdentifier() != $question->id_user)
    <h2>Post your comment</h2>
    <form action="{{ route('newcomment', ['id' => $question->question_id, 'type' => 'QuestionComment']) }}" method="POST">
        {{ csrf_field() }}
        <textarea type="text" name="comment_body" id="comment_body" placeholder="Write your comment here (Be respectful)"></textarea>
        <span class="error" id="post_comment_error">
                    @if ($errors->has('comment_body'))
                    Your comment's body must be between 1 and 4000 characters long.
                    <br>
                    @endif
                </span>
        <button type="submit" id="postComment">
            Post New Comment
        </button>
    </form>
    @endif
    @endauth
    <h2>Comments</h2>
    @each('partials.comment', $comments, 'comment')
</section>

<section id="question_answers">
    @auth
        @if (Auth::user()->getAuthIdentifier() != $question->id_user)
        <h2>Post your answer</h2>
            <form action="{{ route('newanswer', ['id' => $question->question_id]) }}" method="POST">
                {{ csrf_field() }}
                <textarea type="text" name="answer_body" id="answer_body" placeholder="Write your answer here (Be respectful)"></textarea>
                <span class="error" id="post_answer_error">
                    @if ($errors->has('answer_body'))
                    Your answer's body must be between 1 and 4000 characters long.
                    <br>
                    @endif
                </span>
                <button type="submit" id="postAnswer">
                    Post New Answer
                </button>
            </form>
        @endif
    @endauth
    <h2>Answers</h2>
    @each('partials.answer', $answers, 'answer')
</section>


@endsection