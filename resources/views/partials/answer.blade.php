<div class="answer-view-mode" id="answer_view_{{ $answer->answer_id }}">
    @auth
    @if (Auth::user()->getAuthIdentifier() != $answer->id_user)
    <div id="vote_section" class="vote">
        <div id="upVoteButton" class="answer_upvote">&#8593;</div>
        @if ($answer->rating >= 0)
        <span id="rating" data-id="{{ $answer->answer_id }}"> {{ $answer->rating }} </span>
        @else
        <span id="rating" data-id="{{ $answer->answer_id }}"> 0 </span>
        @endif
        <div id="downVoteButton" class="answer_downvote">&#8595;</div>
    </div>
    @endif
    @endauth
    <h3 id="answer_text_body_display">
        {{ $answer->text_body }}
    </h3>
    @auth
    @if (Auth::user()->getAuthIdentifier() == $answer->id_user || \App\Models\User::where('user_id', Auth::user()->getAuthIdentifier())->first()->is_admin)
    <button class="answer_edit_button" data-answer-id="{{ $answer->answer_id }}">&#9998;</button>
    <form action ="{{ route('deleteanswer', ['id' => $answer->answer_id]) }}" method = "POST">
        {{ csrf_field() }}
        <button type="submit" class="answer_delete">&#10761;</button>
    </form>
    @endif
    @if (Auth::user()->getAuthIdentifier() != $answer->id_user)
    <h4>Post your comment</h4>
    <form action="{{ route('newcomment', ['id' => $answer->answer_id, 'type' => 'AnswerComment']) }}" method="POST">
        {{ csrf_field() }}
        <textarea type="text" name="comment_body" id="comment_body" placeholder="Write your comment here (Be respectful)"></textarea>
        <span class="error" id="post_comment_error">
                 @if ($errors->has('comment_body'))
                     Your comment's body must be between 1 and 4000 characters long.
                     <br>
                 @endif
            </span>
        <button type="submit" class="post-comment-btn" id='postCommentA' data-answer-id="{{ $answer->answer_id }}">
            Post New Comment
        </button>
    </form>
    @endif
    @endauth
    <h4 class="comment_title">Comments</h4>
    @each('partials.answer_comment', $answer->comments, 'commentA')
</div>
<section class="answer-edit-mode" id="answer_edit_{{ $answer->answer_id }}" style="display: none;">

    <form method = "POST" action = "{{ route('editinganswer', ['id' => $answer->answer_id]) }}" >
        {{ csrf_field() }}

        <h2 id="answer_edit_text_body">
            <input type="text" name="answer_body" id="answer_text_body_edit" value="{{ $answer->text_body }}"></input>
            @if ($errors->has('answer_body'))
            <span class="error">
                    Your text body must be between 5 and 4000 characters long.
                    </span>
            <br>
            @endif
        </h2>
        <button type="reset" class="cancelAnswerButton" data-answer-id="{{ $answer->answer_id }}">
            Cancel
        </button>
        <button type="submit" class="applyAnswerButton" data-answer-id="{{ $answer->answer_id }}">
            Apply
        </button>
    </form>
</section>