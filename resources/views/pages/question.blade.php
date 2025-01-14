@extends('layouts.app')

@section('title', $question->title)

@section('styles')
<link href="{{ url('css/question.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script> window.questionID = "{{ $question->question_id }}"</script>
<script type="text/javascript" src={{ url('js/questionPage.js') }} defer> </script>
@endsection

@section('content')
<section id="question">
    @auth
    @if (Auth::user()->getAuthIdentifier() != $question->id_user && !Auth::user()->is_blocked)
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
    <span id="question_buttons">
    @auth
    @if (Auth::user()->getAuthIdentifier() == $question->id_user || \App\Models\Admin::where('admin_id', Auth::user()->getAuthIdentifier())->exists() || \App\Models\Moderator::where('mod_id', Auth::user()->getAuthIdentifier())->exists())
        <form action ="{{ route('deletequestion', ['id' => $question->question_id]) }}" method = "POST">
            {{ csrf_field() }}
            <button type="submit" class="delete">&#10761;</button>
        </form>

        <button type="submit" class="edit" id="question_edit_button">&#9998;</button>
    @endif
    @endauth
    </span>
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
        @if (Auth::user()->getAuthIdentifier() != $question->id_user && !Auth::user()->is_blocked)
        @if (\App\Models\UserQuestionFollow::where('id_user', Auth::user()->getAuthIdentifier())->where('id_question', $question->question_id)->exists())
        	<div id="followQuestion" class="button" data-question_id="{{ $question->question_id }}"> Unfollow </div>
        @else
            <div id="followQuestion" class="button" data-question_id="{{ $question->question_id }}"> Follow </div>
        @endif
        @endif
    @endauth
    
    <div id="text_body_display">
        {{ $question->text_body }}
    </div>
    <div id="post_info">
        <span id="tags">Tags: |
            @foreach ($question->tags as $tag)
                <a href="/tag/{{ $tag->name }}" class="tag">{{ $tag->name }} |</a>
            @endforeach
        </span>
        <div id="author">
            <a class="indigo" href="{{ route('profile', ['id' => \App\Models\User::where('user_id', $question->id_user)->first()->user_id]) }}" methods="GET"> {{ \App\Models\User::where('user_id', $question->id_user)->first()->username }} </a>
        </div>
        <div id="date">
            Posted on: {{ $question->creation_date }}
        </div>
</section>

@auth
<section id="editMode" style="display: none">

    <form method = "POST" action = "{{ route('editingquestion', ['id' => $question->question_id]) }}" >
        {{ csrf_field() }}
        
        @if ((Auth::user()->getAuthIdentifier() == $question->id_user || \App\Models\Admin::where('admin_id', Auth::user()->getAuthIdentifier())->exists()) && !Auth::user()->is_blocked)

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

        @elseif (\App\Models\Moderator::where('mod_id', Auth::user()->getAuthIdentifier())->exists() && !Auth::user()->is_blocked)

        <h2 id="edit_title_display">
            <input type="text" name="title" id="question_title_edit" value="{{ $question->title }}" readonly></input>
            @if ($errors->has('title'))
            <span class="error">
                Your title must be between 5 and 100 characters long.
            </span>
            <br>
            @endif
        </h2>

        <h2 id="edit_text_body">
            <input type="text" name="text_body" id="question_text_body_edit" value="{{ $question->text_body }}" readonly></input>
            @if ($errors->has('text_body'))
            <span class="error">
                Your text body must be between 5 and 4000 characters long.
            </span>
            <br>
            @endif
        </h2>

        @endif

        <div id="edit_tags">
            @foreach ($tags as $tag)
                @if ($question->tags->contains($tag))
                    <input type="checkbox" class="checkbox_edit_tag" name="tags[]" value="{{ $tag->name }}" checked>{{ $tag->name }}
                @else
                    <input type="checkbox" class="checkbox_edit_tag" name="tags[]" value="{{ $tag->name }}">{{ $tag->name }}
                @endif
            @endforeach
        </div>

        <button type="reset" id="cancelButton">
            Cancel
        </button>
        <button type="submit" id="applyButton">
            Apply
        </button>
    </form>
</section>
@endauth


<section id="question_comments">
    @auth
    @if (Auth::user()->getAuthIdentifier() != $question->id_user && !Auth::user()->is_blocked)
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
        <button type="submit" id="postCommentQ">
            Post New Comment
        </button>
    </form>
    @endif
    @endauth
    <h2>Comments</h2>
    @each('partials.comment', $question->comments, 'commentQ')
</section>

<section id="answer_section">
    @auth
    @if (Auth::user()->getAuthIdentifier() != $question->id_user && !Auth::user()->is_blocked)
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
    @each('partials.answer', $question->answers, 'answer')
</section>
@endsection