@extends('layouts.app')

@section('title', 'Home')

@section('content')

<section id="home">
    <form action="{{ route('newquestion') }}">
        <button type="submit">

            Post New Question

        </button>
    </form>

    @each('partials.question', $questions, 'question')
</section>

@endsection