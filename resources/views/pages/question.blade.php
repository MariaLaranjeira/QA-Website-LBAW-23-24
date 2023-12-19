@extends('layouts.app')

@section('title', $question->title)

@section('styles')
<link href="{{ url('css/question.css') }}" rel="stylesheet">
<link href="{{ url('css/font-awesome.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script>window.questionID = "{{ $question->question_id }}"</script>
<script type="text/javascript" src={{ url('js/questionPage.js') }} defer> </script>
@endsection

@section('content')
<section id="question">
    @auth
        @if (Auth::user()->getAuthIdentifier() == $question->id_user || \App\Models\Admin::where('admin_id', Auth::user()->getAuthIdentifier())->exists())
            <form action ="{{ route('deletequestion', ['id' => $question->question_id]) }}" method = "POST">
                {{ csrf_field() }}
                <button type="submit" class="delete">&#10761;</button>
            </form>

            <button type="submit" class="edit" id="question_edit_button">&#9998;</button>
        @endif
        @if (Auth::user()->getAuthIdentifier() != $question->id_user)
            <div id="vote_section" class="vote">
                <div id="upVoteButton" class="upvote">&#8593;</div>
                @if ($question->rating >= 0)
                    <span id="rating"> {{ $question->rating }} </span>
                @else
                    <span id="rating"> 0 </span>
                @endif
                <div id="downVoteButton" class="downvote">&#8595;</div>
            </div>
        @endif
    @endauth
    <h2 id="title_display">
        <div id="question_title">
            {{ $question->title }}
        </div>
    </h2>


    @if ($question -> media_address != 'default.jpg')
        <div id="questionPic">
            <img src="/images/question/{{ $question->media_address }}" alt="Question Picture" >
        </div>
    @endif

    
    @auth
        @if (Auth::user()->getAuthIdentifier() == $question->id_user || \App\Models\Admin::where('admin_id', Auth::user()->getAuthIdentifier())->exists())
         <a class="button" href="{{ url('/edit_question_picture', ['id' => $question->question_id]) }}"> Add picture </a>
        @endif
    @endauth
    
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