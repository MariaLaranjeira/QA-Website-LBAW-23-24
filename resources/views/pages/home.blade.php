@extends('layouts.app')

@section('title', 'Home')

@section('content')

<section id="home">
    @each('partials.question', $questions, 'question')
    <form action="{{ route('newquestion') }}">
        <button type="submit">

            Post New Question

        </button>
    </form>
</section>

@endsection