<article class="answer" data-id="{{ $answer->answer_id }}">

   
    <header>
        <h2>{{ $answer->text_body }}</h2>
    </header>

    @if ($answer -> media_address != 'default.jpg')
        <div id="answerPic">
            <img src="/images/answer/{{ $answer->media_address }}" alt="Answer Picture">
        </div>
    @endif

</article>