<a href="/question/{{ $question->question_id }}">
    <article class="question" data-id="{{ $question->question_id }}">
        <header>
            <h3>{{ $question->title }}</h3>
        </header>
        <body>
            <p>{{ $question->text_body }}</p>
        </body>
    </article>
</a>