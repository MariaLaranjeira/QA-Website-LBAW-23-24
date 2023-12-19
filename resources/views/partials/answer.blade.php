<article class="answer" data-id="{{ $answer->answer_id }}">
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
    <header>
        <h2>{{ $answer->text_body }}</h2>
    </header>

    @if ($answer -> media_address != 'default.jpg')
        <div id="answerPic">
            <img src="/images/answer/{{ $answer->media_address }}" alt="Answer Picture">
        </div>
    @endif

</article>