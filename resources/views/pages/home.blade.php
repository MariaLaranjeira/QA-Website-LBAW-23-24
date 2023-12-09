@extends('layouts.app')

@section('title', 'CreativeHub Home')

@section('content')

<section id="home">
    @auth
        <form action="{{ route('newquestion') }}">
            <button type="submit">

                Post New Question

            </button>
        </form>
    @endauth
    <h2>Recent Questions</h2>

    @each('partials.question', $questions, 'question')
</section>

@endsection