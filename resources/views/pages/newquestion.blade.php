@extends('layouts.app')

@section('title', 'New Question')

@section('content')

<section id = "new_question">
    <form method="POST" class="new_question" action="{{ route('createnewquestion') }}">
        {{ csrf_field() }}
        <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Question Title">
        <textarea type="text" name="text_body" id="text_body" value="{{ old('text_body') }}" placeholder="Insert your question here"></textarea>
        <button type="submit" class="new_question">
            Post a Question
        </button>
    </form>
</section>
@endsection