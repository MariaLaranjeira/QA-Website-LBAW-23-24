@extends('layouts.app')

@section('title', 'Create Question')

@section('styles')
<link href="{{ url('css/new.question.css') }}" rel="stylesheet">
@endsection

@section('content')

<section id = "new_question">
    <form method="POST" class="new_question" action="{{ route('createnewquestion') }}">
        {{ csrf_field() }}
        <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Question Title">
        @if ($errors->has('title'))
        <br>
        <span class="error">
          Your title must be between 5 and 100 characters long.
        </span>
        @endif
        <textarea type="text" name="text_body" id="text_body" value="{{ old('text_body') }}" placeholder="Insert your question here"></textarea>
        @if ($errors->has('text_body'))
        <span class="error">
          Your text body must be between 5 and 4000 characters long.
        </span>
        <br>
        @endif
        <button type="submit" class="new_question">
            Post a Question
        </button>
    </form>
</section>
@endsection