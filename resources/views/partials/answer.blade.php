@section('answer_body', $answer->answer_body)

<article class="answer" data-id="{{ $answer->answer_id }}">
    <div>
        {{ $answer->answer_body }}
    </div>
<\article>