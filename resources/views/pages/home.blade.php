@extends('layouts.app')

@section('title', 'Home')

@section('content')

<section id="home">
    @auth
        <form action="{{ route('newquestion') }}">
            <button type="submit">

                Post New Question

            </button>
        </form>
    @endauth

    @each('partials.question', $questions, 'question')
</section>

@endsection